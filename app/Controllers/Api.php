<?php

namespace App\Controllers;

use App\Models\WaitlistModel;
use App\Models\TalentProfileModel;
use App\Models\UserModel;
use App\Models\InteractionRequestModel;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    // ── POST /api/waitlist ──────────────────────────────────────────
    public function waitlist()
    {
        $name  = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $role  = $this->request->getPost('role');

        if (empty($name) || empty($email) || empty($role)) {
            return $this->failValidationErrors('Name, email, and role are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->failValidationErrors('Invalid email address.');
        }

        $model = new WaitlistModel();

        $existing = $model->findByEmail($email);
        if ($existing) {
            return $this->respondUpdated(['message' => 'You are already on the list!']);
        }

        $id = $model->insert([
            'name'   => $name,
            'email'  => $email,
            'role'   => $role,
            'status' => 'pending',
        ]);

        return $this->respondCreated([
            'message' => 'You are on the list!',
            'id'      => $id,
        ]);
    }

    // ── GET /api/waitlist/stats ─────────────────────────────────────
    public function waitlistStats()
    {
        $model = new WaitlistModel();
        return $this->respond($model->getStats());
    }

    // ── GET /api/talents ────────────────────────────────────────────
    public function talents()
    {
        $model = new TalentProfileModel();

        $filters = [
            'q'            => $this->request->getGet('q'),
            'availability' => $this->request->getGet('availability')
                                ? explode(',', $this->request->getGet('availability'))
                                : [],
            'experience'    => $this->request->getGet('experience')
                                ? explode(',', $this->request->getGet('experience'))
                                : [],
            'sort'         => $this->request->getGet('sort') ?? 'newest',
        ];

        $page   = (int) $this->request->getGet('page') ?: 1;
        $limit   = 12;
        $offset  = ($page - 1) * $limit;

        $talents = $model->withUser()->search($filters, $limit, $offset);
        $total   = $model->countFiltered($filters);
        $stats   = $model->getStats();

        foreach ($talents as &$t) {
            if ($t['skills'] && is_string($t['skills'])) {
                $t['skills_array'] = json_decode($t['skills'], true) ?? [];
            } else {
                $t['skills_array'] = [];
            }
        }

        return $this->respond([
            'talents'    => $talents,
            'stats'      => $stats,
            'pagination' => [
                'page'       => $page,
                'limit'      => $limit,
                'total'      => $total,
                'totalPages' => ceil($total / $limit),
            ],
        ]);
    }

    // ── GET /api/talents/:id ────────────────────────────────────────
    public function talent(int $id)
    {
        $model = new TalentProfileModel();
        $talent = $model->withUser()->find($id);

        if (!$talent) {
            return $this->failNotFound('Talent profile not found.');
        }

        if ($talent['skills'] && is_string($talent['skills'])) {
            $talent['skills_array'] = json_decode($talent['skills'], true) ?? [];
        } else {
            $talent['skills_array'] = [];
        }

        return $this->respond($talent);
    }

    // ── POST /api/offers ────────────────────────────────────────────
    public function sendOffer()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized('Please log in to send an offer.');
        }
        if (session()->get('role') !== 'employer') {
            return $this->failForbidden('Only employers can send offers.');
        }

        $talentId       = (int) $this->request->getPost('talent_id');
        $subject        = $this->request->getPost('subject');
        $proposedSalary = $this->request->getPost('proposed_salary');
        $offerType      = $this->request->getPost('offer_type');
        $message        = $this->request->getPost('message');

        if (!$talentId || !$subject || !$offerType) {
            return $this->failValidationErrors('Talent ID, subject, and offer type are required.');
        }

        $validTypes = ['free_interview', 'paid_interview', 'paid_assessment'];
        if (!in_array($offerType, $validTypes)) {
            return $this->failValidationErrors('Invalid offer type.');
        }

        $offerModel = new InteractionRequestModel();
        $employerId = session()->get('user_id');

        $id = $offerModel->insert([
            'employer_id'     => $employerId,
            'talent_id'      => $talentId,
            'type'           => $offerType,
            'subject'        => $subject,
            'proposed_salary'=> $proposedSalary,
            'message'        => $message,
            'status'         => 'pending',
        ]);

        // Create notification for talent
        $notifModel = new NotificationModel();
        $notifModel->createNotification(
            $talentId,
            'offer_received',
            'New Offer Received',
            "You received an offer: {$subject}",
            '/talent/profile'
        );

        return $this->respondCreated(['message' => 'Offer sent!', 'id' => $id]);
    }

    // ── GET /api/offers/sent ────────────────────────────────────────
    public function sentOffers()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'employer') {
            return $this->failUnauthorized('Unauthorized.');
        }

        $offerModel = new InteractionRequestModel();
        $employerId = session()->get('user_id');
        $offers = $offerModel->sentByEmployer($employerId);
        $monthCount = $offerModel->countThisMonth($employerId);

        return $this->respond([
            'offers' => $offers,
            'monthCount' => $monthCount,
        ]);
    }

    // ── GET /api/offers/incoming ────────────────────────────────────
    public function incomingOffers()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'talent') {
            return $this->failUnauthorized('Unauthorized.');
        }

        $offerModel = new InteractionRequestModel();
        $talentId = session()->get('user_id');
        $offers = $offerModel->receivedByTalent($talentId);

        return $this->respond(['offers' => $offers]);
    }

    // ── POST /api/offers/:id/accept ────────────────────────────────
    public function acceptOffer(int $id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'talent') {
            return $this->failUnauthorized('Unauthorized.');
        }

        $offerModel = new InteractionRequestModel();
        $offer = $offerModel->find($id);

        if (!$offer || $offer['talent_id'] != session()->get('user_id')) {
            return $this->failNotFound('Offer not found.');
        }

        if ($offer['status'] !== 'pending') {
            return $this->failValidationErrors('This offer has already been responded to.');
        }

        $offerModel->update($id, [
            'status'       => 'accepted',
            'responded_at' => date('Y-m-d H:i:s'),
        ]);

        // Notify employer
        $notifModel = new NotificationModel();
        $notifModel->createNotification(
            $offer['employer_id'],
            'offer_accepted',
            'Offer Accepted!',
            'Your offer has been accepted.',
            '/employer/discover'
        );

        return $this->respond(['message' => 'Offer accepted!']);
    }

    // ── POST /api/offers/:id/decline ───────────────────────────────
    public function declineOffer(int $id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'talent') {
            return $this->failUnauthorized('Unauthorized.');
        }

        $offerModel = new InteractionRequestModel();
        $offer = $offerModel->find($id);

        if (!$offer || $offer['talent_id'] != session()->get('user_id')) {
            return $this->failNotFound('Offer not found.');
        }

        if ($offer['status'] !== 'pending') {
            return $this->failValidationErrors('This offer has already been responded to.');
        }

        $offerModel->update($id, [
            'status'       => 'declined',
            'responded_at' => date('Y-m-d H:i:s'),
        ]);

        // Notify employer
        $notifModel = new NotificationModel();
        $notifModel->createNotification(
            $offer['employer_id'],
            'offer_declined',
            'Offer Declined',
            'Your offer was not accepted.',
            '/employer/discover'
        );

        return $this->respond(['message' => 'Offer declined.']);
    }

    // ── GET /api/notifications/unread-count ─────────────────────────
    public function unreadNotificationCount()
    {
        if (!session()->get('logged_in')) {
            return $this->respond(['count' => 0]);
        }

        $notifModel = new NotificationModel();
        $count = $notifModel->unreadCount(session()->get('user_id'));

        return $this->respond(['count' => $count]);
    }

    // ── GET /api/notifications/recent ───────────────────────────────
    public function recentNotifications()
    {
        if (!session()->get('logged_in')) {
            return $this->respond(['notifications' => []]);
        }

        $notifModel = new NotificationModel();
        $recent = $notifModel->recentForUser(session()->get('user_id'), 5);

        return $this->respond(['notifications' => $recent]);
    }

    // ── POST /api/notifications/:id/read ───────────────────────────
    public function markNotificationRead(int $id)
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized('Unauthorized.');
        }

        $notifModel = new NotificationModel();
        $notifModel->markRead($id, session()->get('user_id'));

        return $this->respond(['message' => 'Marked as read.']);
    }
}
