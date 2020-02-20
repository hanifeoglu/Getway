<template>
  <div class="wrapper" id="appi">
    <div class="card-form">
      <div class="card-form__inner" style="padding:35px;margin-bottom:35px;text-align:center;">
        <div v-if="payment">
          <h1>{{payment.name}}</h1>
          <p>{{payment.description}}</p>
          <h2>$ {{payment.amount}}</h2>
        </div>
        <div v-else>Loading payment details.</div>
      </div>
    </div>
    <CardForm
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
      payment: null
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
      axios
        .post(`/payments/${this.paymentKey}`, {
          pan: this.formattedCardNumber,
          expiry: this.formattedExpiry,
          cvv2: this.formData.cardCvv,
          type: this.cardType
        })
        .then(response => {
          console.log(response);
        })
        .catch(error => {
          console.log(error);
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
