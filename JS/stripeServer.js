const express = require('express');
const stripe = require('stripe')('your-secret-api-key'); // Replace with your actual secret key
const app = express();

app.use(express.json());

// Route to start the Stripe OAuth process
app.get('/connect', (req, res) => {
  // Replace with your actual client ID from Stripe Connect
  const oauthUrl = `https://connect.stripe.com/oauth/authorize?response_type=code&client_id=your-client-id&scope=read_write&redirect_uri=http://localhost:3000/oauth/callback`;
  res.redirect(oauthUrl);
});

// Callback route after Stripe login
app.get('/oauth/callback', async (req, res) => {
  const { code } = req.query;

  if (!code) {
    return res.status(400).send('Missing authorization code');
  }

  try {
    // Exchange the authorization code for an access token
    const response = await stripe.oauth.token({
      grant_type: 'authorization_code',
      code,
    });

    // Store the access token securely in your database (or session)
    const connectedAccountId = response.stripe_user_id;

    // Redirect to the custom dashboard page
    res.redirect(`/dashboard?account_id=${connectedAccountId}`);
  } catch (err) {
    res.status(500).send('OAuth Error');
  }
});

// Route to display the Stripe Dashboard with user data
app.get('/dashboard', async (req, res) => {
  const { account_id } = req.query;

  if (!account_id) {
    return res.status(400).send('Missing account ID');
  }

  try {
    // Get payment data for the connected account
    const payments = await stripe.paymentIntents.list({
      limit: 10, // You can adjust this as needed
      stripeAccount: account_id,
    });

    // Send the payments data to the frontend (or render a template with it)
    res.json(payments);
  } catch (err) {
    res.status(500).send('Error fetching payments');
  }
});

// Start the server
const port = 3000;
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});
