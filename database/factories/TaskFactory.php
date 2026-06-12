<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Sinh câu ngẫu nhiên làm tiêu đề
            'title' => fake()->sentence(4), 
            // Sinh đoạn văn ngẫu nhiên làm mô tả
            'description' => fake()->paragraph(), 
            // Chọn ngẫu nhiên 1 trong 3 trạng thái
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed']), 
            // Sinh ngày hạn chót ngẫu nhiên từ 1 tuần trước đến 2 tuần sau
            'due_date' => fake()->dateTimeBetween('-1 week', '+2 weeks'), 
            // Gán tạm cho user đầu tiên trong hệ thống (tài khoản bạn đang dùng)
            'assigned_to' => 1, 
            'created_by' => 1,
        ];
    }
}