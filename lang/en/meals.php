<?php

return [
    // General titles
    'meals' => 'Meals',
    'meal' => 'Meal',
    'create_meal' => 'Create Meal',
    'create_new_meal' => 'Create New Meal',
    'edit_meal' => 'Edit Meal',
    'meal_details' => 'Meal Details',
    'meal_list' => 'Meals List',
    'no_meals_found' => 'No meals found',
    'meal_id' => 'Meal ID',

    // Meal fields
    'meal_name' => 'Meal Name',
    'meal_name_en' => 'Meal Name (English)',
    'meal_name_ar' => 'Meal Name (Arabic)',
    'description' => 'Description',
    'description_en' => 'Description (English)',
    'description_ar' => 'Description (Arabic)',
    'price' => 'Price',
    'category' => 'Category',
    'select_category' => 'Select Category',
    'preparation_time' => 'Preparation Time',
    'minutes' => 'minutes',
    'meal_image' => 'Meal Image',
    'availability' => 'Availability',
    'available' => 'Available',
    'status' => 'Status',
    'active' => 'Active',
    'image_help' => 'Choose an image for the meal (optional)',
    'discount_number' => 'Discount',
    'expiration_date' => 'Expiration Date',
    'sort_order' => 'Sort Order',
    'meal_popular' => 'Popular Meal',
    'popular_meals' => 'Popular Meals',
    'select_popular_meals' => 'Select Popular Meals',

    // Ingredients
    'ingredients' => 'Ingredients',
    'ingredient' => 'Ingredient',
    'add_ingredient' => 'Add Ingredient',
    'remove_ingredient' => 'Remove Ingredient',
    'select_ingredient' => 'Select Ingredient',
    'quantity' => 'Quantity',
    'unit' => 'Unit',
    'notes' => 'Notes',
    'optional_notes' => 'Optional notes',
    'ingredients_help' => 'Add the required ingredients to prepare this meal with the required quantities',
    'max_available' => 'Max available',
    'quantity_exceeds_stock' => 'Quantity exceeds available stock',

    // Validation messages
    'please_add_at_least_one_ingredient' => 'Please add at least one ingredient',
    'please_complete_all_ingredients' => 'Please complete all ingredient data',
    'cannot_remove_last_ingredient' => 'Cannot remove the last ingredient',
    'add_first_ingredient' => 'Add First Ingredient',
    'add_another_ingredient' => 'Add Another Ingredient',

    // Sizes & Extras
    'size' => 'Size',
    'meal_sizes' => 'Meal Sizes',
    'meal_sizes_description' => 'Manage meal sizes and prices',
    'add_new_size' => 'Add New Size',
    'delete_size' => 'Delete Size',
    'no_sizes' => 'No sizes available',
    'size_name_en' => 'Size Name (English)',
    'size_name_ar' => 'Size Name (Arabic)',
    'size_name_en_placeholder' => 'Enter size name (English)',
    'size_name_ar_placeholder' => 'Enter size name (Arabic)',
    'meal_extras' => 'Meal Extras',
    'meal_extras_description' => 'Manage meal extras and add-ons',
    'add_new_extra' => 'Add New Extra',
    'delete_extra' => 'Delete Extra',
    'no_extras' => 'No extras available',
    'extra_name_en' => 'Extra Name (English)',
    'extra_name_ar' => 'Extra Name (Arabic)',
    'extra_name_en_placeholder' => 'Enter extra name (English)',
    'extra_name_ar_placeholder' => 'Enter extra name (Arabic)',

    // Placeholders
    'placeholders' => [
        'enter_meal_name' => 'Enter meal name',
        'enter_description' => 'Enter meal description',
        'enter_price' => 'Enter price',
        'select_category' => 'Select category',
        'enter_preparation_time' => 'Enter preparation time in minutes',
        'select_size' => 'Select size',
        'discount' => 'Enter discount',
    ],

    // Meal statuses
    'statuses' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    // Success and error messages
    'meal_created' => 'Meal created successfully',
    'meal_updated' => 'Meal updated successfully',
    'meal_deleted' => 'Meal deleted successfully',
    'meal_not_found' => 'Meal not found',

    // Show page
    'basic_information' => 'Basic Information',
    'quick_stats' => 'Quick Stats',
    'current_image' => 'Current Image',
    'no_image' => 'No Image',
    'no_ingredients' => 'No Ingredients',
    'no_ingredients_description' => 'No ingredients have been added to this meal yet',
    'unavailable' => 'Unavailable',
    'inactive' => 'Inactive',
    'view_meal' => 'View Meal',
    'update_meal' => 'Update Meal',
    'delete_meal_confirm' => 'Confirm Delete Meal',
    'delete_warning' => 'Are you sure you want to delete this meal?',
    'delete_warning_description' => 'This action cannot be undone. All data related to this meal will be deleted.',
    'delete_meal' => 'Delete Meal',

    // Buttons
    'save' => 'Save',
    'cancel' => 'Cancel',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'view' => 'View',
    'add_meal' => 'Add Meal',
    // Meals table
    'table' => [
        'name' => 'Name',
        'category' => 'Category',
        'price' => 'Price', 
        'status' => 'Status',
        'availability' => 'Availability',
        'preparation_time' => 'Preparation Time',
        'actions' => 'Actions',
        'image' => 'Image',
        'ingredients_count' => 'Ingredients Count',
        'created_at' => 'Created At',
        "description" => 'Description',
        "category_id" => 'category Id'
    ],

    'categories' => [
        'cheese' => 'Cheese',
        'meat' => 'Meat',
        'other' => 'Other',
        'sauce' => 'Sauce',
        'spices' => 'Spices',
        'vegetables' => 'Vegetables',
    ],

    'sizes' => [
        'sm' => 'Small',
        'md' => 'Medium',
        'lg' => 'Large',
        'single' => 'Single',
        'double' => 'Double',
    ],
];
