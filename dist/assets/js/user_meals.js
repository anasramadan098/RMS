const mealsInput =  document.querySelector('input[name="user_meals"]'); 
const quantatityInputs = document.querySelectorAll('.meals input');
let meals = JSON.parse(mealsInput.value);

if (meals.length != 0) {
    meals.map(item => {
        quantatityInputs[item.id - 1].value = item.qty;
    })
}

quantatityInputs.forEach(input => {
    input.addEventListener('input' , () => {
        
        if (input.value == 0) {
            meals = meals.filter(meal => meal.id !== input.dataset.id);
            mealsInput.value = JSON.stringify(meals);
            return;
        } else if (input.value < 0) {
            input.value = 0;
            return;
        }
        const existingMeal = meals.find(meal => meal.id === input.dataset.id);
        if (existingMeal) {
            existingMeal.qty = input.value;
        } else {
            meals.push({"id": input.dataset.id, "qty": input.value , "name" : input.dataset.name});
        }
        
        mealsInput.value = JSON.stringify(meals);
    })
})
