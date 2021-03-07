@extends('layouts.transaction')

<!-- @ section('title','Informations personelles') -->

@section('content')
    <div class="card col-md-9 offset-md-3 mx-auto py-4">
        <h1 class="mb-5 text-center text-blue">{{ session("payment_title") }}</h1>
        <h4 class="col-12 text-center">Vous pouvez payer en utilisant votre carte bancaire ou votre compte PayPal</h4>
        <div type="button" class="btn btn-default">
            Montant à payer : <h2 class="badge bg-primary" style="font-size: 2rem">${{session('price')}}.00</h2>
        </div>
        <div class="spacer"></div>
        <form action="{{ session('form_action') }}" method="POST" id="payment-form">
            @csrf
            <input type="hidden" name="user_id" value="{{session('user_details')['user_id']}}">
            <div class="row">
                <div id="credit-card-wrapper" class="row bg-gray-light m-0">
                  <div class="col-md-6">
                      <label for="cc_number">Numéro de Carte de Crédit</label>
                      <div class="form-group" id="card-number">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <label for="expiry">Expiration</label>
                      <div class="form-group" id="expiration-date">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <label for="cvv">CVV</label>
                      <div class="form-group" id="cvv">
                      </div>
                  </div>
                </div>

            </div>

            <div class="spacer"></div>

            <div id="paypal-button" class="justify-content-center row pt-4 bg-primary"></div>

            <div class="spacer"></div>

            <input id="nonce" name="payment_method_nonce" type="hidden" />
            <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-money-check-alt"></i> Soumettre le paiement</button>
        </form>
    </div>

    <script src="https://js.braintreegateway.com/web/3.38.1/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.38.1/js/hosted-fields.min.js"></script>

    <!-- Load PayPal's checkout.js Library. -->
    <script src="https://www.paypalobjects.com/api/checkout.js" data-version-4 log-level="warn"></script>

    <!-- Load the PayPal Checkout component. -->
    <script src="https://js.braintreegateway.com/web/3.38.1/js/paypal-checkout.min.js"></script>
    <script>

      var form = document.querySelector('#payment-form');
      var submit = document.querySelector('input[type="submit"]');

    braintree.client.create({
      authorization: '{{ session("token") }}'
    }, function (clientErr, clientInstance) {
        if (clientErr) {
          console.error(clientErr);
          return;
        }

        // This example shows Hosted Fields, but you can also use this
        // client instance to create additional components here, such as
        // PayPal or Data Collector.

        braintree.hostedFields.create({
          client: clientInstance,
          styles: {
            'input': {
              'font-size': '14px'
            },
            'input.invalid': {
              'color': 'red'
            },
            'input.valid': {
              'color': 'green'
            }
          },
          fields: {
            number: {
              selector: '#card-number',
              placeholder: '4111 1111 1111 1111'
            },
            cvv: {
              selector: '#cvv',
              placeholder: '123'
            },
            expirationDate: {
              selector: '#expiration-date',
              placeholder: '10/2019'
            }
          }
        }, function (hostedFieldsErr, hostedFieldsInstance) {
          if (hostedFieldsErr) {
            console.error(hostedFieldsErr);
            return;
          }

           //submit.removeAttribute('disabled');

          form.addEventListener('submit', function (event) {
            event.preventDefault();

            hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
              if (tokenizeErr) {
                console.error(tokenizeErr);
                return;
              }

              // If this was a real integration, this is where you would
              // send the nonce to your server.
              // console.log('Got a nonce: ' + payload.nonce);
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          }, false);
        });

        // Create a PayPal Checkout component.
        braintree.paypalCheckout.create({
            client: clientInstance
        }, function (paypalCheckoutErr, paypalCheckoutInstance) {

        // Stop if there was a problem creating PayPal Checkout.
        // This could happen if there was a network error or if it's incorrectly
        // configured.
        if (paypalCheckoutErr) {
          console.error('Error creating PayPal Checkout:', paypalCheckoutErr);
          return;
        }

        // Set up PayPal with the checkout.js library
        paypal.Button.render({
          env: 'sandbox', // or 'production'
          commit: true,

          payment: function () {
            return paypalCheckoutInstance.createPayment({
              // Your PayPal options here. For available options, see
              // http://braintree.github.io/braintree-web/current/PayPalCheckout.html#createPayment
              flow: 'checkout', // Required
              amount: {{session('price')}}, // Required
              currency: 'CAD', // Required
            });
          },

          onAuthorize: function (data, actions) {
            return paypalCheckoutInstance.tokenizePayment(data, function (err, payload) {

              // Submit `payload.nonce` to your server.
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          },

          onCancel: function (data) {
            console.log('checkout.js payment cancelled', JSON.stringify(data, 0, 2));
          },

          onError: function (err) {
            console.error('checkout.js error', err);
          }
        }, '#paypal-button').then(function () {
          // The PayPal button will be rendered in an html element with the id
          // `paypal-button`. This function will be called when the PayPal button
          // is set up and ready to be used.
        });
      });


    });
    </script>
@endsection
