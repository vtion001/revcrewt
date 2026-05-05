<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\TalentProfileModel;

class TalentSeed extends Seeder
{
    public function run()
    {
        $model = new TalentProfileModel();

        $talents = [
            [
                'user_id' => 1,
                'headline' => 'Senior Full-Stack Developer',
                'summary' => '8 years of experience building scalable web applications. Specialized in React, Node.js, and cloud architecture on AWS. Led teams of 5+ engineers at previous companies.',
                'location' => 'Manila, PH',
                'skills' => json_encode(['React', 'Node.js', 'TypeScript', 'AWS', 'PostgreSQL', 'Docker', 'GraphQL']),
                'experience_years' => 8,
                'availability_status' => 'open',
                'salary_min' => 250000,
                'salary_max' => 400000,
                'profile_completion' => 90,
                'is_premium' => 1,
                'verified_badge' => 1,
            ],
            [
                'user_id' => 2,
                'headline' => 'UX/UI Designer',
                'summary' => 'Creative designer with 5 years crafting user-centered digital experiences. Expert in Figma, design systems, and accessibility standards. Previously at a fintech startup.',
                'location' => 'Cebu, PH',
                'skills' => json_encode(['Figma', 'Adobe XD', 'Prototyping', 'Design Systems', 'User Research', 'CSS', 'Framer']),
                'experience_years' => 5,
                'availability_status' => 'exploring',
                'salary_min' => 120000,
                'salary_max' => 200000,
                'profile_completion' => 75,
                'is_premium' => 0,
                'verified_badge' => 0,
            ],
            [
                'user_id' => 3,
                'headline' => 'Data Scientist & ML Engineer',
                'summary' => 'PhD in Applied Mathematics. 6 years building ML models for healthcare and finance. Expert in Python, TensorFlow, and data pipeline architecture.',
                'location' => 'Makati, PH',
                'skills' => json_encode(['Python', 'TensorFlow', 'PyTorch', 'SQL', 'Data Engineering', 'A/B Testing', 'MLOps']),
                'experience_years' => 6,
                'availability_status' => 'open',
                'salary_min' => 300000,
                'salary_max' => 500000,
                'profile_completion' => 95,
                'is_premium' => 1,
                'verified_badge' => 1,
            ],
            [
                'user_id' => 4,
                'headline' => 'DevOps Engineer',
                'summary' => 'Infrastructure specialist with 4 years automating CI/CD pipelines and managing Kubernetes clusters. Reduced deployment time by 70% at last role.',
                'location' => 'Davao, PH',
                'skills' => json_encode(['Kubernetes', 'Docker', 'Terraform', 'AWS', 'GCP', 'CI/CD', 'Linux', 'Python']),
                'experience_years' => 4,
                'availability_status' => 'receptive',
                'salary_min' => 180000,
                'salary_max' => 280000,
                'profile_completion' => 80,
                'is_premium' => 0,
                'verified_badge' => 0,
            ],
            [
                'user_id' => 5,
                'headline' => 'Product Manager',
                'summary' => 'PM with 7 years shipping consumer and B2B products. Strong background in agile, user research, and roadmap planning. Ex-Grab, ex-GCash.',
                'location' => 'Manila, PH',
                'skills' => json_encode(['Product Strategy', 'Agile', 'Jira', 'Figma', 'SQL', 'Analytics', 'Roadmapping']),
                'experience_years' => 7,
                'availability_status' => 'open',
                'salary_min' => 220000,
                'salary_max' => 350000,
                'profile_completion' => 85,
                'is_premium' => 1,
                'verified_badge' => 0,
            ],
            [
                'user_id' => 6,
                'headline' => 'Junior Frontend Developer',
                'summary' => 'Bootcamp graduate with a passion for clean code and great UX. Building projects daily. Seeking a team where I can grow into a full-stack role.',
                'location' => 'Quezon City, PH',
                'skills' => json_encode(['JavaScript', 'React', 'HTML', 'CSS', 'Git', 'Tailwind']),
                'experience_years' => 1,
                'availability_status' => 'open',
                'salary_min' => 40000,
                'salary_max' => 70000,
                'profile_completion' => 60,
                'is_premium' => 0,
                'verified_badge' => 0,
            ],
            [
                'user_id' => 7,
                'headline' => 'Mobile Developer (React Native)',
                'summary' => '4 years building cross-platform mobile apps with React Native. Published 3 apps with 100K+ downloads. Focused on performance and smooth animations.',
                'location' => 'Iloilo, PH',
                'skills' => json_encode(['React Native', 'TypeScript', 'iOS', 'Android', 'Firebase', 'Redux', 'Fastlane']),
                'experience_years' => 4,
                'availability_status' => 'exploring',
                'salary_min' => 150000,
                'salary_max' => 220000,
                'profile_completion' => 70,
                'is_premium' => 0,
                'verified_badge' => 0,
            ],
            [
                'user_id' => 8,
                'headline' => 'QA Engineer & Automation Specialist',
                'summary' => '5 years of QA experience with strong automation skills. Built test frameworks from scratch using Playwright and Cypress. Also do performance testing.',
                'location' => 'Manila, PH',
                'skills' => json_encode(['Playwright', 'Cypress', 'Selenium', 'API Testing', 'Jest', 'Performance Testing', 'CI/CD']),
                'experience_years' => 5,
                'availability_status' => 'open',
                'salary_min' => 100000,
                'salary_max' => 160000,
                'profile_completion' => 65,
                'is_premium' => 0,
                'verified_badge' => 0,
            ],
        ];

        foreach ($talents as $t) {
            $model->insert($t);
        }

        echo "Seeded " . count($talents) . " talent profiles.\n";
    }
}
