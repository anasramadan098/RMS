<?php

return [
    // Main headings
    'bookings' => 'Bookings',
    'booking' => 'Booking',
    'booking_list' => 'Booking List',
    'booking_details' => 'Booking Details',
    'add_booking' => 'Add Booking',
    'edit_booking' => 'Edit Booking',
    'view_booking' => 'View Booking',
    'delete_booking' => 'Delete Booking',
    'new_booking' => 'New Booking',

    // Messages
    'booking_created' => 'Booking created successfully!',
    'booking_updated' => 'Booking updated successfully!',
    'booking_deleted' => 'Booking deleted successfully!',
    'booking_save_failed' => 'Failed to save booking',
    'booking_delete_failed' => 'Failed to delete booking',
    'booking_not_found' => 'Booking not found',
    'delete_booking_confirm' => 'Are you sure you want to delete this booking?',
    'status_updated' => 'Booking status updated successfully!',
    'status_update_failed' => 'Failed to update booking status',

    // Form labels
    'customer_name' => 'Customer Name',
    'phone_number' => 'Phone Number',
    'number_of_guests' => 'Number of Guests',
    'date_time' => 'Date & Time',
    'event_description' => 'Event Description',
    'status' => 'Status',
    'client' => 'Client',
    'link_to_client' => 'Link to Client',
    'select_client_optional' => 'Select a client (optional)',

    // Status values
    'status_pending' => 'Pending',
    'status_confirmed' => 'Confirmed',
    'status_cancelled' => 'Cancelled',
    'status_completed' => 'Completed',

    // Table headers
    'table' => [
        'name' => 'Name',
        'phone' => 'Phone',
        'guests' => 'Guests',
        'datetime' => 'Date & Time',
        'event' => 'Event',
        'client' => 'Client',
        'status' => 'Status',
        'actions' => 'Actions',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    // Form placeholders and help text
    'placeholders' => [
        'name' => 'Enter customer name',
        'phone' => 'Enter phone number',
        'guests' => '1',
        'event' => 'Describe the event details (birthday party, business meeting, etc.)',
        'search_name' => 'Search by name...',
        'search_phone' => 'Search by phone...',
    ],

    // Sections
    'customer_information' => 'Customer Information',
    'booking_details' => 'Booking Details',
    'record_information' => 'Record Information',
    'quick_status_update' => 'Quick Status Update',

    // Validation messages
    'validation' => [
        'name_required' => 'Customer name is required',
        'phone_required' => 'Phone number is required',
        'guests_required' => 'Number of guests is required',
        'guests_min' => 'At least 1 guest is required',
        'guests_max' => 'Maximum 100 guests allowed',
        'datetime_required' => 'Date and time is required',
        'datetime_future' => 'Booking date must be in the future',
        'event_required' => 'Event description is required',
        'status_invalid' => 'Invalid status selected',
        'client_exists' => 'Selected client does not exist',
    ],

    // Additional text
    'guest' => 'Guest',
    'guests_plural' => 'Guests',
    'no_bookings_found' => 'No bookings found',
    'no_client' => 'No Client',
    'linked_client' => 'Linked Client',
    'upcoming' => 'Upcoming',
    'past' => 'Past',
    'yes' => 'Yes',
    'no' => 'No',
    'created' => 'Created',
    'last_updated' => 'Last Updated',
    'update_status' => 'Update Status',
    'back_to_bookings' => 'Back to Bookings',
    'cancel' => 'Cancel',
    'create_booking' => 'Create Booking',
    'update_booking' => 'Update Booking',
    'save' => 'Save',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'view' => 'View',

    // Filter text
    'all_statuses' => 'All Statuses',
    'filter_by_name' => 'Filter by Name',
    'filter_by_phone' => 'Filter by Phone',
    'filter_by_status' => 'Filter by Status',
    'filter_by_date' => 'Filter by Date',
];