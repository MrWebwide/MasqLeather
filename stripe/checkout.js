// Publishable key injected by checkout.php from .env
const stripe = Stripe(window.STRIPE_PK);

initialize();

// Create a Checkout Session as soon as the page loads
async function initialize() {
  // Göreli yol: hem local (/Masq-Latest/stripe/) hem prod (/stripe/) altında çalışır
  const response = await fetch("checkout.php", {
    method: "POST",
  });

  const { clientSecret } = await response.json();

  const checkout = await stripe.initEmbeddedCheckout({
    clientSecret,
  });

  // Mount Checkout
  checkout.mount('#checkout');
}