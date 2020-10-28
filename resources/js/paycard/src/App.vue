<template>
  <div class="wrapper" v-if="payment">
    <div class="card-form">
      <div
        class="card-form__inner"
        style="padding: 35px; margin-bottom: 35px; text-align: center"
      >
        <div>
          <h1>{{ payment.name }}</h1>
          <p>{{ payment.description }}</p>
          <h2>{{ payment.amount }} TL</h2>
          <span v-if="payment.is_paid" style="color: green">
            <h3>Thank you for payment.</h3>
            <p>Your payment received at {{ payment.paid_at }}</p>
          </span>
          <span v-if="onProcess" style="color: orange">
            <h3>Please Wait</h3>
            <p>Getting your payment. Please wait.</p>
          </span>
          <span v-if="paymentError" style="color: red">
            <h3>Error!</h3>
            <p>{{ paymentError }}</p>
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
    <form
      id="real3DForm"
      method="post"
      :action="paymentFormData.endpoint"
      style="display: none"
    >
      <input type="hidden" name="Pan" v-model="formattedCardNumber" />
      <input type="hidden" name="Cvv2" v-model="formData.cardCvv" />
      <input type="hidden" name="Expiry" v-model="formattedExpiry" />
      <input type="hidden" name="BonusAmount" value="" />
      <input type="hidden" name="CardType" value="0" />
      <input type="hidden" name="ShopCode" :value="paymentFormData.shopCode" />
      <input
        type="hidden"
        name="PurchAmount"
        :value="paymentFormData.purchaseAmount"
      />
      <input type="hidden" name="Currency" :value="paymentFormData.currency" />
      <input type="hidden" name="OrderId" :value="paymentFormData.orderId" />
      <input type="hidden" name="OkUrl" :value="paymentFormData.okUrl" />
      <input type="hidden" name="FailUrl" :value="paymentFormData.failUrl" />
      <input type="hidden" name="Rnd" :value="paymentFormData.rnd" />
      <input type="hidden" name="Hash" :value="paymentFormData.hash" />
      <input type="hidden" name="TxnType" :value="paymentFormData.txnType" />
      <input
        type="hidden"
        name="InstallmentCount"
        :value="paymentFormData.installmentCount"
      />
      <input type="hidden" name="SecureType" value="3DPay" />
      <input type="hidden" name="Lang" value="en" />
    </form>
  </div>
  <div v-else>Loading payment details ...</div>
</template>

<script>
import CardForm from "./components/CardForm";
export default {
  name: "app",
  components: {
    CardForm,
  },
  data() {
    return {
      formData: {
        cardName: "",
        cardNumber: "",
        cardMonth: "",
        cardYear: "",
        cardCvv: "",
      },
      rawCardNumber: "",
      payment: null,
      error: null,
      onProcess: false,
      paymentFormData: {
        endpoint: "",
        shopCode: "",
        purchaseAmount: "",
        orderId: "",
        currency: "",
        okUrl: "",
        failUrl: "",
        rnd: "",
        installmentCount: "",
        txnType: "",
        hash: "",
      },
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
      document.getElementById("real3DForm").submit();
    },
  },
  computed: {
    paymentKey() {
      return document.head.querySelector('meta[name="payment-key"]').content;
    },
    paymentError() {
      return document.head.querySelector('meta[name="payment-error"]').content;
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
    },
  },
  beforeMount() {
    axios.get(`/payment/${this.paymentKey}`).then((response) => {
      this.payment = response.data.payment;
      this.paymentFormData = response.data.formdata;
    });
  },
};
</script>

<style lang="scss">
@import "../src/assets/style.scss";
</style>
