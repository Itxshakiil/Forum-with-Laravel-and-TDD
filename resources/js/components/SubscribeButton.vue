<template>
  <button
    class="w-full px-4 py-2 mt-2 font-bold text-white rounded-full focus:outline-none"
    @click="subscribe"
    :class="classes"
  >Subscribe</button>
</template>
<script>
export default {
  props: ["active"],
  data() {
    return {
      subcribed: this.active
    };
  },
  computed: {
    classes() {
      return [
        this.subcribed
          ? "bg-blue-500 hover:bg-blue-700"
          : "bg-gray-700 hover:bg-gray-900"
      ];
    }
  },
  methods: {
    subscribe() {
      axios[this.subcribed ? "delete" : "post"](
        location.pathname + "/subscriptions"
      );

      this.subcribed = !this.subcribed;
      flash("Subscibed");
    }
  }
};
</script>