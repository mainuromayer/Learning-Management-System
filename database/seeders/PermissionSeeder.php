<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User management
        $moduleAppUser = Module::updateOrCreate(['title' => 'User', 'slug' => Str::slug('user')]);
        Permission::updateOrCreate(['module_id' => $moduleAppUser->id, 'title' => 'Access User', 'slug' => 'app.users.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppUser->id, 'title' => 'Create User', 'slug' => 'app.users.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppUser->id, 'title' => 'Edit User', 'slug' => 'app.users.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppUser->id, 'title' => 'Delete User', 'slug' => 'app.users.destroy',]);

        // AboutUs Permission
        $moduleAppAboutUs = Module::updateOrCreate(['title' => 'AboutUs', 'slug' => Str::slug('about_us')]);
        Permission::updateOrCreate(['module_id' => $moduleAppAboutUs->id, 'title' => 'Access About Us', 'slug' => 'app.about_us.index',]);

        // Category Permission
        $moduleAppCategory = Module::updateOrCreate(['title' => 'Category', 'slug' => Str::slug('category')]);
        Permission::updateOrCreate(['module_id' => $moduleAppCategory->id, 'title' => 'Access Category', 'slug' => 'app.category.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppCategory->id, 'title' => 'Create Category', 'slug' => 'app.category.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppCategory->id, 'title' => 'Edit Category', 'slug' => 'app.category.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppCategory->id, 'title' => 'Delete Category', 'slug' => 'app.category.destroy',]);


        // Course Permission
        $moduleAppCourse = Module::updateOrCreate(['title' => 'Course', 'slug' => Str::slug('course')]);
        Permission::updateOrCreate(['module_id' => $moduleAppCourse->id, 'title' => 'Access Course', 'slug' => 'app.course.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppCourse->id, 'title' => 'Create Course', 'slug' => 'app.course.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppCourse->id, 'title' => 'Edit Course', 'slug' => 'app.course.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppCourse->id, 'title' => 'Delete Course', 'slug' => 'app.course.destroy',]);


        // Lesson Permission
        $moduleAppLesson = Module::updateOrCreate(['title' => 'Lesson', 'slug' => Str::slug('lesson')]);
        Permission::updateOrCreate(['module_id' => $moduleAppLesson->id, 'title' => 'Access Course Lesson', 'slug' => 'app.lesson.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppLesson->id, 'title' => 'Create Course Lesson', 'slug' => 'app.lesson.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppLesson->id, 'title' => 'Edit Course Lesson', 'slug' => 'app.lesson.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppLesson->id, 'title' => 'Delete Course Lesson', 'slug' => 'app.lesson.destroy',]);

        // Quiz Permission
        $moduleAppQuiz = Module::updateOrCreate(['title' => 'Quiz', 'slug' => Str::slug('quiz')]);
        Permission::updateOrCreate(['module_id' => $moduleAppQuiz->id, 'title' => 'Access Course Quiz', 'slug' => 'app.quiz.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppQuiz->id, 'title' => 'Create Course Quiz', 'slug' => 'app.quiz.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppQuiz->id, 'title' => 'Edit Course Quiz', 'slug' => 'app.quiz.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppQuiz->id, 'title' => 'Delete Course Quiz', 'slug' => 'app.quiz.destroy',]);

        // Section Permission
        $moduleAppSection = Module::updateOrCreate(['title' => 'Section', 'slug' => Str::slug('section')]);
        Permission::updateOrCreate(['module_id' => $moduleAppSection->id, 'title' => 'Access Course Section', 'slug' => 'app.section.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppSection->id, 'title' => 'Create Course Section', 'slug' => 'app.section.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppSection->id, 'title' => 'Edit Course Section', 'slug' => 'app.section.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppSection->id, 'title' => 'Delete Course Section', 'slug' => 'app.section.destroy',]);



        // EnrollStudent Permission
        $moduleAppEnrollStudent = Module::updateOrCreate(['title' => 'EnrollStudent', 'slug' => Str::slug('enroll_student')]);
        Permission::updateOrCreate(['module_id' => $moduleAppEnrollStudent->id, 'title' => 'Access Enroll Student', 'slug' => 'app.enroll_student.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppEnrollStudent->id, 'title' => 'Create Enroll Student', 'slug' => 'app.enroll_student.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppEnrollStudent->id, 'title' => 'Edit Enroll Student', 'slug' => 'app.enroll_student.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppEnrollStudent->id, 'title' => 'Delete Enroll Student', 'slug' => 'app.enroll_student.destroy',]);

        // Assignment Permission
        $moduleAppAssignment = Module::updateOrCreate(['title' => 'Assignment', 'slug' => Str::slug('assignment')]);
        Permission::updateOrCreate(['module_id' => $moduleAppAssignment->id, 'title' => 'Access Assignment', 'slug' => 'app.assignment.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppAssignment->id, 'title' => 'Create Assignment', 'slug' => 'app.assignment.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppAssignment->id, 'title' => 'Edit Assignment', 'slug' => 'app.assignment.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppAssignment->id, 'title' => 'Delete Assignment', 'slug' => 'app.assignment.destroy',]);


        // Instructor Permission
        $moduleAppInstructor = Module::updateOrCreate(['title' => 'Instructor', 'slug' => Str::slug('instructor')]);
        Permission::updateOrCreate(['module_id' => $moduleAppInstructor->id, 'title' => 'Access Instructor', 'slug' => 'app.instructor.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppInstructor->id, 'title' => 'Create Instructor', 'slug' => 'app.instructor.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppInstructor->id, 'title' => 'Edit Instructor', 'slug' => 'app.instructor.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppInstructor->id, 'title' => 'Delete Instructor', 'slug' => 'app.instructor.destroy',]);


        // Student Permission
        $moduleAppStudent = Module::updateOrCreate(['title' => 'Student', 'slug' => Str::slug('student')]);
        Permission::updateOrCreate(['module_id' => $moduleAppStudent->id, 'title' => 'Access Student', 'slug' => 'app.student.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppStudent->id, 'title' => 'Create Student', 'slug' => 'app.student.create',]);
        Permission::updateOrCreate(['module_id' => $moduleAppStudent->id, 'title' => 'Edit Student', 'slug' => 'app.student.edit',]);
        Permission::updateOrCreate(['module_id' => $moduleAppStudent->id, 'title' => 'Delete Student', 'slug' => 'app.student.destroy',]);


        // User Permission
        $moduleAppUserPermission = Module::updateOrCreate(['title' => 'User Permission', 'slug' => Str::slug('user_permission')]);
        Permission::updateOrCreate(['module_id' => $moduleAppUserPermission->id, 'title' => 'View User Permissions', 'slug' => 'app.user_permission.index',]);
        Permission::updateOrCreate(['module_id' => $moduleAppUserPermission->id, 'title' => 'Update User Permissions', 'slug' => 'app.user_permission.update',]);
    }
}
