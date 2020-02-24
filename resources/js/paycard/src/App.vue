<template>
  <div class="wrapper" v-if="payment">
    <div class="card-form">
      <div class="card-form__inner" style="padding:35px;margin-bottom:35px;text-align:center;">
        <div>
          <h1>{{payment.name}}</h1>
          <p>{{payment.description}}</p>
          <h2>$ {{payment.amount}}</h2>
          <span v-if="payment.is_paid" style="color:green;">
            <h3>Thank you for payment.</h3>
            <p>Your payment received at {{payment.paid_at}}</p>
          </span>
          <span v-if="onProcess" style="color:orange;">
            <h3>Please Wait</h3>
            <p>Getting your payment. Please wait.</p>
          </span>
          <span v-if="error" style="color:red;">
            <h3>Error!</h3>
            <p>{{error}}</p>
          </span>
        </div>
      </div>
    </div>
    <CardForm
      v-if="!payment.is_paid && !onProcess"
      :form-data="formData"
      @input-card-number="updateCardNumber"
      @input-card-name="updateCardName"
      @input-card-month="updateCardMonth"
      @input-card-year="updateCardYear"
      @input-card-cvv="updateCardCvv"
      @submit-form="sendPayment"
    />
    <!-- backgroundImage="https://images.unsplash.com/photo-1572336183013-960c3e1a0b54?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2250&q=80" -->
  </div>
  <div v-else>Loading payment details ...</div>
</template>

<script>
import CardForm from "./components/CardForm";
export default {
  name: "app",
  components: {
    CardForm
  },
  data() {
    return {
      formData: {
        cardName: "",
        cardNumber: "",
        cardMonth: "",
        cardYear: "",
        cardCvv: ""
      },
      rawCardNumber: "",
      payment: null,
      error: null,
      onProcess: false
    };
  },
  methods: {
    updateCardNumber(val) {
      this.rawCardNumber = val;
    },
    updateCardName(val) {},
    updateCardMonth(val) {},
    updateCardYear(val) {},
    updateCardCvv(val) {},
    sendPayment() {
      this.error = null;
      this.onProcess = true;
      axios
        .post(`/payments/${this.paymentKey}`, {
          pan: this.formattedCardNumber,
          expiry: this.formattedExpiry,
          cvv2: this.formData.cardCvv,
          type: this.cardType
        })
        .then(response => {
          console.log(response);
          this.payment = response.data.payment;
        })
        .catch(error => {
          console.log(error);
          if (error.response.data.payment) {
            this.payment = error.response.data.payment;
          }

          if (error.response.data.message) {
            this.error = error.response.data.message;
          }
        })
        .then(() => {
          this.onProcess = false;
        });
    }
  },
  computed: {
    paymentKey() {
      return document.head.querySelector('meta[name="payment-key"]').content;
    },
    formattedCardNumber() {
      return this.rawCardNumber.replace(/\s/g, "");
    },
    formattedExpiry() {
      return (
        this.formData.cardMonth + this.formData.cardYear.toString().slice(-2)
      );
    },
    cardType() {
      let number = this.formattedCardNumber;
      let re = new RegExp("^4");
      if (number.match(re) != null) return "visa";

      re = new RegExp("^(34|37)");
      if (number.match(re) != null) return "amex";

      re = new RegExp("^5[1-5]");
      if (number.match(re) != null) return "mastercard";

      re = new RegExp("^6011");
      if (number.match(re) != null) return "discover";

      re = new RegExp("^62");
      if (number.match(re) != null) return "unionpay";

      re = new RegExp("^9792");
      if (number.match(re) != null) return "troy";

      re = new RegExp("^3(?:0([0-5]|9)|[689]\\d?)\\d{0,11}");
      if (number.match(re) != null) return "dinersclub";

      re = new RegExp("^35(2[89]|[3-8])");
      if (number.match(re) != null) return "jcb";

      return ""; // default type
    }
  },
  beforeMount() {
    axios.get(`/payment/${this.paymentKey}`).then(response => {
      this.payment = response.data;
    });
  }
};
</script>

<style lang="scss">
@import "../src/assets/style.scss";
</style>
