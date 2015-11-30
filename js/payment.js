(function(){
	"use strict";
	var braintree, paymentOptions, printScreen;

	// Payment JS - require jquery
	paymentOptions = document.getElementById('payment_choice');
	printScreen = document.getElementById('print_screen');

	if(paymentOptions){
		paymentOptions = paymentOptions.querySelectorAll('button');
		for (var i = paymentOptions.length - 1; i >= 0; i--) {
			paymentOptions[i].addEventListener("click", paymentChoice);
		}
	}

	if(printScreen){
		printScreen.addEventListener("click", printMe);
	}

	// click payment option buttons
	function paymentChoice(event){
		document.querySelector('input[name="method"]').value = this.getAttribute('name');
		document.getElementById('form_value_method').submit();
	}
	// click print payment button
	function printMe(event){
		window.print();
	}

	// Braintree Encrypt
	if(typeof braintreeClientKey != 'undefined' && braintreeClientKey){
		braintree = Braintree.create(braintreeClientKey);
		braintree.onSubmitEncryptForm("form_cc");
	}
})();