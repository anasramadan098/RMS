<?php

return [
    // General
    'projects' => 'Projects',
    'project' => 'Project',
    'project_management' => 'Project Management',
    'project_list' => 'Project List',
    'project_details' => 'Project Details',
    'add_project' => 'Add Project',
    'edit_project' => 'Edit Project',
    'create_project' => 'Create Project',
    'update_project' => 'Update Project',
    'delete_project' => 'Delete Project',
    'view_project' => 'View Project',
    'project_information' => 'Project Information',
    'project_history' => 'Project History',
    'project_statistics' => 'Project Statistics',
    'name' => 'Name',
    'user' => 'User',
    'completed' => 'Completed',
    'on_hold' => 'On Hold',

    // Fields
    'project_name' => 'Project Name',
    'project_title' => 'Project Title',
    'description' => 'Description',
    'client' => 'Client',
    'manager' => 'Project Manager',
    'team' => 'Team',
    'start_date' => 'Start Date',
    'end_date' => 'End Date',
    'deadline' => 'Deadline',
    'budget' => 'Budget',
    'cost' => 'Cost',
    'progress' => 'Progress',
    'status' => 'Status',
    'priority' => 'Priority',
    'category' => 'Category',
    'tags' => 'Tags',
    'notes' => 'Notes',
    'attachments' => 'Attachments',
    'completion_percentage' => 'Completion Percentage',
    'estimated_hours' => 'Estimated Hours',
    'actual_hours' => 'Actual Hours',

    // Status
    'statuses' => [
        'planning' => 'Planning',
        'in_progress' => 'In Progress',
        'on_hold' => 'On Hold',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'delayed' => 'Delayed',
    ],

    // Priority
    'priorities' => [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent',
        'critical' => 'Critical',
    ],

    // Categories
    'categories' => [
        'web_development' => 'Web Development',
        'mobile_app' => 'Mobile App',
        'design' => 'Design',
        'marketing' => 'Marketing',
        'consulting' => 'Consulting',
        'research' => 'Research',
        'other' => 'Other',
    ],

    // Actions
    'add_new_project' => 'Add New Project',
    'edit_project_info' => 'Edit Project Information',
    'delete_project_confirm' => 'Are you sure you want to delete this project?',
    'view_project_details' => 'View Project Details',
    'export_projects' => 'Export Projects',
    'import_projects' => 'Import Projects',
    'assign_team' => 'Assign Team',
    'update_progress' => 'Update Progress',
    'mark_completed' => 'Mark as Completed',
    'archive_project' => 'Archive Project',

    // Messages
    'project_created' => 'Project has been created successfully.',
    'project_updated' => 'Project has been updated successfully.',
    'project_deleted' => 'Project has been deleted successfully.',
    'project_not_found' => 'Project not found.',
    'no_projects_found' => 'No projects found.',
    'projects_exported' => 'Projects have been exported successfully.',
    'projects_imported' => 'Projects have been imported successfully.',
    'progress_updated' => 'Project progress has been updated successfully.',

    // Validation
    'project_name_required' => 'Project name is required.',
    'description_required' => 'Project description is required.',
    'client_required' => 'Client is required.',
    'start_date_required' => 'Start date is required.',
    'end_date_required' => 'End date is required.',
    'budget_required' => 'Budget is required.',
    'budget_numeric' => 'Budget must be a number.',

    // Statistics
    'total_projects' => 'Total Projects',
    'active_projects' => 'Active Projects',
    'completed_projects' => 'Completed Projects',
    'overdue_projects' => 'Overdue Projects',
    'projects_this_month' => 'Projects This Month',
    'average_completion_time' => 'Average Completion Time',
    'total_budget' => 'Total Budget',
    'spent_budget' => 'Spent Budget',

    // Filters
    'filter_by_status' => 'Filter by Status',
    'filter_by_priority' => 'Filter by Priority',
    'filter_by_category' => 'Filter by Category',
    'filter_by_client' => 'Filter by Client',
    'filter_by_date_range' => 'Filter by Date Range',
    'search_projects' => 'Search Projects',
    'search_by_name_description' => 'Search by name or description',

    // Table Headers
    'table' => [
        'id' => 'ID',
        'project_name' => 'Project Name',
        'client' => 'Client',
        'manager' => 'Manager',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'budget' => 'Budget',
        'progress' => 'Progress',
        'status' => 'Status',
        'priority' => 'Priority',
        'actions' => 'Actions',
        'created_at' => 'Created Date',
    ],

    // Form Labels
    'form' => [
        'basic_information' => 'Basic Information',
        'project_details' => 'Project Details',
        'timeline' => 'Timeline',
        'budget_information' => 'Budget Information',
        'team_assignment' => 'Team Assignment',
        'additional_information' => 'Additional Information',
        'select_client' => 'Select Client',
        'select_manager' => 'Select Manager',
        'select_status' => 'Select Status',
        'select_priority' => 'Select Priority',
        'select_category' => 'Select Category',
    ],

    // Reports
    'reports' => [
        'project_report' => 'Project Report',
        'progress_report' => 'Progress Report',
        'budget_report' => 'Budget Report',
        'timeline_report' => 'Timeline Report',
        'team_performance' => 'Team Performance',
        'client_projects' => 'Client Projects',
    ],

    // Placeholders
    'placeholders' => [
        'enter_project_name' => 'Enter project name',
        'enter_description' => 'Enter project description',
        'enter_budget' => 'Enter budget amount',
        'enter_notes' => 'Enter project notes',
        'search_projects' => 'Search projects...',
    ],

    // Progress
    'progress_labels' => [
        'not_started' => 'Not Started',
        'in_progress' => 'In Progress',
        'almost_done' => 'Almost Done',
        'completed' => 'Completed',
    ],

    // Timeline
    'timeline' => [
        'project_created' => 'Project Created',
        'project_started' => 'Project Started',
        'milestone_reached' => 'Milestone Reached',
        'project_completed' => 'Project Completed',
        'project_delayed' => 'Project Delayed',
        'budget_exceeded' => 'Budget Exceeded',
    ],
];
