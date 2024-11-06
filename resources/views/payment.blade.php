<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <form action="/payment" method="POST" id="payment-form">
        @csrf
        <input type="text" name="amount" placeholder="Enter amount" required>
        <div id="card-element"></div>
        <button type="submit">Pay Now</button>
        <div id="card-errors" role="alert"></div>
    </form>

    <script>
        // Create a Stripe client
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        
        // Create an instance of the card Element
        var card = elements.create('card');
        // Add an instance of the card Element into the `card-element` div
        card.mount('#card-element');

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    document.getElementById('card-errors').textContent = result.error.message;
                } else {
                    // Send the token to your server
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);

                    // Submit the form
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
