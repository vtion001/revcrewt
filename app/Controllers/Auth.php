<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmployerProfileModel;
use App\Models\TalentProfileModel;
use App\Models\NotificationModel;

class Auth extends BaseController
{
    public function login(): string
    {
        $data['page'] = 'auth-login';
        $data['page_title'] = 'Login — revcrewt';
        return view('auth/login-page', $data);
    }

    public function register(): string
    {
        $data['page'] = 'auth-register';
        $data['page_title'] = 'Register — revcrewt';
        return view('auth/register-page', $data);
    }

    public function attemptLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role') ?? 'talent';

        if (empty($email) || empty($password)) {
            return redirect()->to('/auth/login')->withInput()->with('error', 'Email and password are required.');
        }

        $userModel = new UserModel();
        $user = $userModel->verifyCredentials($email, $password);

        if (!$user) {
            return redirect()->to('/auth/login')->withInput()->with('error', 'Invalid email or password.');
        }

        if ($user['role'] !== $role) {
            $expected = $role === 'employer' ? 'Talent' : 'Employer';
            return redirect()->to('/auth/login')->withInput()
                ->with('error', "This account is registered as {$expected}. Please use the correct login tab.");
        }

        if ($user['status'] !== 'active') {
            return redirect()->to('/auth/login')->withInput()->with('error', 'Your account has been suspended.');
        }

        session()->set([
            'user_id'    => (int) $user['id'],
            'name'       => $user['name'] ?? '',
            'email'      => $user['email'],
            'role'       => $user['role'],
            'logged_in'  => true,
        ]);

        $userModel->updateLastLogin($user['id']);

        if ($user['role'] === 'employer') {
            return redirect()->to('/employer/discover');
        }
        return redirect()->to('/talent/profile');
    }

    public function attemptRegister()
    {
        $role              = $this->request->getPost('role') ?? 'talent';
        $name              = trim($this->request->getPost('name'));
        $email             = trim($this->request->getPost('email'));
        $password           = $this->request->getPost('password');
        $passwordConfirm    = $this->request->getPost('password_confirmation');
        $companyName       = trim($this->request->getPost('company_name'));
        $headline          = trim($this->request->getPost('headline'));

        if (empty($name) || empty($email) || empty($password) || empty($passwordConfirm)) {
            return redirect()->to('/auth/register')->withInput()->with('error', 'All fields are required.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to('/auth/register')->withInput()->with('error', 'Invalid email address.');
        }
        if (strlen($password) < 8) {
            return redirect()->to('/auth/register')->withInput()->with('error', 'Password must be at least 8 characters.');
        }
        if ($password !== $passwordConfirm) {
            return redirect()->to('/auth/register')->withInput()->with('error', 'Passwords do not match.');
        }
        if ($role === 'employer' && empty($companyName)) {
            return redirect()->to('/auth/register')->withInput()->with('error', 'Company name is required for employers.');
        }
        if ($role === 'talent' && empty($headline)) {
            return redirect()->to('/auth/register')->withInput()->with('error', 'Headline is required for talent.');
        }

        $userModel = new UserModel();

        if ($userModel->findByEmail($email)) {
            return redirect()->to('/auth/register')->withInput()->with('error', 'An account with this email already exists.');
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $userId = $userModel->createUser($name, $email, $passwordHash, $role);

        if (!$userId) {
            return redirect()->to('/auth/register')->withInput()->with('error', 'Registration failed. Please try again.');
        }

        if ($role === 'employer') {
            (new EmployerProfileModel())->insert([
                'user_id'    => $userId,
                'org_name'   => $companyName,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            // Try to create talent profile (may fail for IDs 1-8 which have seeded profiles)
            try {
                $talentModel = new TalentProfileModel();
                $existingProfile = db_connect()->table('talent_profiles')->where('user_id', $userId)->countAllResults();
                if ($existingProfile === 0) {
                    $talentModel->skipValidation(true)->insert([
                        'user_id'    => $userId,
                        'headline'   => $headline ?: $name . "'s Profile",
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
                (new NotificationModel())->createNotification(
                    $userId,
                    'welcome',
                    'Welcome to revcrewt!',
                    'Complete your profile to get matched with employers.',
                    '/talent/profile'
                );
            } catch (\Throwable $e) {
                log_message('error', 'Profile/notification creation failed: ' . $e->getMessage());
            }
        }

        return redirect()->to('/auth/login')->with('success', 'Account created. Please log in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
