<template>
  <div
    class="flash-alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-2 rounded w-64"
    role="alert" v-show="show">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{body}}</span>
  </div>
</template>

<script>
export default {
  props: ["message"],
  data() {
    return {
      body: '',
      show: false,
    };
  },created() {
      if(this.message){
          this.flash(this.message);
      }
      window.events.$on('flash',message => this.flash(message))
  },
  methods: {
      flash(message){
          this.body = message
          this.show=true

          this.hide()
      },
      hide(){
          setTimeout(()=>{
              this.show = false
          },3000)
      }
  },
};
</script>
<style scoped>
.flash-alert{
  position:fixed;
  bottom:30px;
  right:30px;
}
</style>