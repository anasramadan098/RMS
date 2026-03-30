<?php

return [
    // General titles
    'ingredients' => 'Ingredients',
    'ingredient' => 'Ingredient',
    'ingredient_name' => 'Ingredient Name',
    'ingredient_details' => 'Ingredient Details',
    'stock' => 'Stock',
    'unit' => 'Unit',
    'available_stock' => 'Available Stock',
    'out_of_stock' => 'Out of Stock',
    'low_stock' => 'Low Stock',

    // Form fields
    'name' => 'Name',
    'description' => 'Description',
    'quantity' => 'Quantity',
    'stock_quantity' => 'Stock Quantity',
    'cost' => 'Cost',
    'price_per_unit' => 'Price Per Unit',
    'expiry_date' => 'Expiry Date',
    'supplier' => 'Supplier',
    'supplier_id' => 'Supplier',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',

    // Actions
    'add_ingredient' => 'Add Ingredient',
    'edit_ingredient' => 'Edit Ingredient',
    'create_ingredient' => 'Create Ingredient',
    'create_new_ingredient' => 'Create New Ingredient',
    'create' => 'Create',
    'update_ingredient' => 'Update Ingredient',
    'delete_ingredient' => 'Delete Ingredient',
    'confirm_delete' => 'Are you sure you want to delete this ingredient?',
    'view_ingredient' => 'View Ingredient',
    'manage_ingredients' => 'Manage Ingredients',
    'ingredient_list' => 'Ingredient List',
    'ingredient_management' => 'Ingredient Management',
    'min_stock_level' => 'Minimum Stock Level',
    'select_supplier' => 'Select Supplier',

    // Status messages
    'ingredient_created' => 'Ingredient created successfully',
    'ingredient_updated' => 'Ingredient updated successfully',
    'ingredient_deleted' => 'Ingredient deleted successfully',
    'ingredient_not_found' => 'Ingredient not found',
    'no_ingredients_found' => 'No ingredients found',

    // Validation messages
    'name_required' => 'Ingredient name is required',
    'quantity_required' => 'Quantity is required',
    'unit_required' => 'Unit is required',
    'cost_required' => 'Cost is required',
    'supplier_required' => 'Supplier is required',

    // Table
    'table' => [
        'id' => 'ID',
        'name' => 'Name',
        'quantity' => 'Quantity',
        'unit' => 'Unit',
        'cost' => 'Cost',
        'created_at' => 'Created At',
        'actions' => 'Actions',
    ],

    // Placeholders
    'placeholders' => [
        'enter_ingredient_name' => 'Enter ingredient name',
        'enter_description' => 'Enter description',
        'enter_quantity' => 'Enter quantity',
        'enter_unit' => 'Enter unit',
        'enter_cost' => 'Enter cost',
        'enter_min_stock_level' => 'Enter minimum stock level',
    ],

    // Units of measurement
    'units' => [
        'kg' => 'Kg',
        'g' => 'Gram',
        'l' => 'Liter',
        'ml' => 'Milliliter',
        'piece' => 'Piece',
        'cup' => 'Cup',
        'spoon' => 'Spoon',
    ],

    // Inventory status
    'in_stock' => 'In Stock',
    'running_low' => 'Running Low',
    'expired' => 'Expired',
    'near_expiry' => 'Near Expiry',
    'good_condition' => 'Good Condition',
];
