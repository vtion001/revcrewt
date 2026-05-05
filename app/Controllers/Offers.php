<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\InteractionRequestModel;
use App\Models\NotificationModel;
use App\Models\TalentProfileModel;
use App\Models\EmployerProfileModel;

class Offers extends BaseController
{
    use ResponseTrait;
    protected $offerModel;
    protected $notifModel;

    public function __construct()
    {
        $this->offerModel = new InteractionRequestModel();
        $this->notifModel = new NotificationModel();
    }

    private function checkEmployer(): bool
    {
        return session()->get('logged_in') === true && session()->get('role') === 'employer';
    }

    private function checkTalent(): bool
    {
        return session()->get('logged_in') === true && session()->get('role') === 'talent';
    }

    // POST /api/offers — employer sends offer to talent
    public function create()
    {
        if (!$this->checkEmployer()) return $this->failUnauthorized('Employer login required.');

        $employerId = (int) session()->get('user_id');
        $talentId = (int) $this->request->getPost('talent_id');

        if (!$talentId) return $this->fail('Talent ID required.', 400);

        if ($this->offerModel->hasExistingOffer($employerId, $talentId)) {
            return $this->fail('You already have a pending or active offer with this talent.', 409);
        }

        $offerId = $this->offerModel->createOffer($employerId, $talentId, [
            'subject' => trim($this->request->getPost('subject') ?? ''),
            'proposed_salary' => trim($this->request->getPost('proposed_salary') ?? ''),
            'type' => $this->request->getPost('type') ?? 'free_interview',
            'message' => trim($this->request->getPost('message') ?? ''),
        ]);

        $employerProfile = (new EmployerProfileModel())->findByUserId($employerId);
        $this->notifModel->createNotification(
            $talentId,
            'new_offer',
            'New offer received!',
            ($employerProfile['org_name'] ?? 'An employer') . ' sent you an offer: ' . ($this->request->getPost('subject') ?? ''),
            '/talent/profile#offers'
        );

        return $this->respondCreated(['message' => 'Offer sent.', 'offer_id' => $offerId]);
    }

    // GET /api/offers/sent — employer's sent offers
    public function sent()
    {
        if (!$this->checkEmployer()) return $this->failUnauthorized('Employer login required.');
        $offers = $this->offerModel->sentByEmployer((int) session()->get('user_id'));
        return $this->respond(['offers' => $offers]);
    }

    // GET /api/offers/incoming — talent's incoming offers
    public function incoming()
    {
        if (!$this->checkTalent()) return $this->failUnauthorized('Talent login required.');
        $offers = $this->offerModel->receivedByTalent((int) session()->get('user_id'));
        return $this->respond(['offers' => $offers]);
    }

    // POST /api/offers/{id}/accept
    public function accept(int $id)
    {
        if (!$this->checkTalent()) return $this->failUnauthorized('Talent login required.');

        $talentId = (int) session()->get('user_id');
        $offer = $this->offerModel->find($id);

        if (!$offer || (int) $offer['talent_id'] !== $talentId) {
            return $this->fail('Offer not found.', 404);
        }
        if ($offer['status'] !== 'pending') {
            return $this->fail('Already responded to.', 400);
        }

        $this->offerModel->updateStatus($id, 'accepted');
        $this->notifModel->createNotification(
            (int) $offer['employer_id'],
            'offer_accepted',
            'Offer accepted!',
            'A talent accepted your offer: ' . ($offer['subject'] ?? ''),
            '/employer/discover'
        );

        return $this->respondCreated(['message' => 'Offer accepted.']);
    }

    // POST /api/offers/{id}/decline
    public function decline(int $id)
    {
        if (!$this->checkTalent()) return $this->failUnauthorized('Talent login required.');

        $talentId = (int) session()->get('user_id');
        $offer = $this->offerModel->find($id);

        if (!$offer || (int) $offer['talent_id'] !== $talentId) {
            return $this->fail('Offer not found.', 404);
        }
        if ($offer['status'] !== 'pending') {
            return $this->fail('Already responded to.', 400);
        }

        $this->offerModel->updateStatus($id, 'declined');
        $this->notifModel->createNotification(
            (int) $offer['employer_id'],
            'offer_declined',
            'Offer declined',
            'A talent declined your offer: ' . ($offer['subject'] ?? ''),
            '/employer/discover'
        );

        return $this->respondCreated(['message' => 'Offer declined.']);
    }
}
