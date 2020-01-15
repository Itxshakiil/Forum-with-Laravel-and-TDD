<script>
import Replies from "../../components/Replies.vue";
import subscribeButton from "../../components/SubscribeButton";
export default {
  props: ["initialRepliesCount"],
  components: { Replies, subscribeButton },
  data() {
    return {
      repliesCount: this.initialRepliesCount
    };
  }
};
</script>