<template>
  <button
    class="px-4 py-2 border rounded focus:outline-none"
    :class="classes"
    type="submit"
    @click="toggle"
  >
    <span class="text-red-500">♥</span>
    <span v-text="count"></span>
  </button>
</template>
<script>
export default {
  props: ["reply"],
  data() {
    return {
      count: this.reply.favoritesCount,
      active: this.reply.isFavorited
    };
  },
  computed: {
    classes() {
      return [this.active ? "bg-red-200" : "bg-gray-200"];
    },
    endpoints() {
      return "/replies/" + this.reply.id + "/favorites";
    }
  },
  methods: {
    toggle() {
      return this.active ? this.unfavorite() : this.favorite();
    },
    unfavorite() {
      axios.delete(this.endpoints);

      this.count--;
      this.active = false;
    },
    favorite() {
      axios.post(this.endpoints);
      this.count++;
      this.active = true;
    }
  }
};
</script>