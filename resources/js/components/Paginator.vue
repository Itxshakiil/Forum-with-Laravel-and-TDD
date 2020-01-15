<template>
  <div>
    <div class="flex justify-center" v-if="shouldPaginate">
      <a
        href="#"
        class="text-blue-500 p-2"
        rel="prev"
        aria-label="prev"
        v-if="prevUrl"
        @click.prevent="page--"
      >&lsaquo;</a>

      <a
        class="text-blue-500 p-2"
        href="#"
        rel="next"
        aria-label="next"
        v-if="nextUrl"
        @click.prevent="page++"
      >&rsaquo;</a>
    </div>
  </div>
</template>
<script>
export default {
  props: ["dataSet"],
  data() {
    return {
      page: 1,
      prevUrl: true,
      nextUrl: true
    };
  },
  watch: {
    dataSet() {
      this.page = this.dataSet.current_page;
      this.prevUrl = this.dataSet.prev_page_url;
      this.nextUrl = this.dataSet.next_page_url;
    },
    page() {
      this.broadcast();
      this.updateUrl();
    }
  },
  computed: {
    shouldPaginate() {
      return !!this.prevUrl || !!this.nextUrl;
    }
  },
  methods: {
    broadcast() {
      return this.$emit("changed", this.page);
    },
    updateUrl() {
      history.pushState(null, null, "?page=" + this.page);
    }
  }
};
</script>