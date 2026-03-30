const form = document.querySelector('form');


// Check In Storate
let client = JSON.parse(localStorage.getItem('somi_client')) ?? null;

if (client) {
    form.querySelector('input[name="per"]').value = client.per;
}
let result;
document.querySelector('.close').addEventListener('click' , () => {
    overlay.classList.remove('active');
    clientAuth.classList.remove('active');
})




document.querySelector('input[type="number"]').addEventListener('input' , () => {
    const input = event.target;
    if (input.value.length > 2) {
        input.value = input.value.slice(0, 2);
    }
    if (input.value > 50) {
        input.value = 50;
    } else if (input.value < 1) {
        input.value = 1;
    }
})


const overlay = document.querySelector('.overlay');
const clientAuth = document.querySelector('.client-auth');



form.onsubmit = function(e) {
    e.preventDefault();
    
    
    let app = client ? client.app : [];
    // Store In Local Storage
    client = {
        name : form.querySelector('input[name="name"]').value,
        phone: form.querySelector('input[name="phone"]').value,
        last_table_number : form.querySelector('input[name="t_n"]').value,
        per: form.querySelector('input[name="per"]').value ,
        app: [...app , form.querySelector('input[name="app"]').value.split(',')[1]],
        lastFollow : new Date().toLocaleString(),
        purchsed : false,
        spin: false,
        reload :false,
    }
    
    if (form.dataset.go == 'false') {
        client.spin = true;
        client.app = client.app.filter(item => item != null);
    }

    // Set the client data as a JSON string to the hidden input
    form.querySelector('input[name="client_data"]').value = JSON.stringify(client);

    if (form.dataset.go == 'false') {
        
        // Send form data via fetch without refreshing the page
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
        })
        .then(response => response.json())
        .then(data => {
            // Assign a value to result, for example using data.result or another property from the response
            form.querySelector('p').innerHTML = `Give This Code To Cahsier: <span>"${data.code}"</span> To Get <span>${result}</span>`
            localStorage.setItem('somi_client' , JSON.stringify(client));
        
        
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        localStorage.setItem('somi_client' , JSON.stringify(client));
        form.submit();

    }
}