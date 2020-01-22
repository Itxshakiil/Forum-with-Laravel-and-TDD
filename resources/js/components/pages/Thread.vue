<script>
import Replies from "../../components/Replies.vue";
import subscribeButton from "../../components/SubscribeButton";
export default {
  props: ["thread"],
  components: { Replies, subscribeButton },
  data() {
    return {
      repliesCount: this.thread.replies_count,
      locked: this.thread.locked
    };
  },methods: {
    toggleLock(){
      axios[this.locked ? 'delete' : 'post']('/locked-threads/'+ this.thread.slug)
      
      this.locked = !this.locked;
    }
  },
};
</script>