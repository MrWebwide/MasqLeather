// Publishable key injected by checkout.php from .env
const stripe = Stripe(window.STRIPE_PK);

initialize();

// Create a Checkout Session as soon as the page loads
async function initialize() {
  const response = await fetch("/stripe/checkout.php", {
    method: "POST",
  });

  const { clientSecret } = await response.json();

  const checkout = await stripe.initEmbeddedCheckout({
    clientSecret,
  });

  // Mount Checkout
  checkout.mount('#checkout');
}