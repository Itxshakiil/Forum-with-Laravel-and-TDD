<template>
  <article :id="'reply-'+id" class="border p-4 mb-2 rounded">
    <div class="flex">
      <p class="text-sm flex-1">
        <a
          :href="'/profiles/'+this.data.owner.name"
          class="text-blue-500"
          v-text="this.data.owner.name"
        ></a>
        said
        <span v-text="ago"></span> ...
      </p>
      <div v-if="signedIn">
        <favorite :reply="data"></favorite>
      </div>
    </div>
    <div v-if="editing">
      <form @submit="update">
        <textarea
          class="w-full px-3 py-2 m-1 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
          v-model.trim="body"
          required
        ></textarea>
        <button class="p-2 text-blue-900 bg-blue-200 rounded" type="submit">Update</button>
        <button class="p-2 border rounded" @click=" editing = false">Cancel</button>
      </form>
    </div>
    <div v-else v-html="body" class="p-2"></div>
    <div class="flex" v-if="canUpdate">
      <button
        class="px-3 py-2 mb-3 mr-2 text-sm leading-tight text-gray-700 border rounded appearance-none focus:outline-none"
        @click="edit"
      >Edit</button>
      <button
        class="px-3 py-2 mb-3 text-sm leading-tight bg-red-300 text-red-700 border rounded appearance-none focus:outline-none"
        @click="destroy"
      >Delete</button>
    </div>
  </article>
</template>
<script>
import Favorite from "./Favorite.vue";
import moment from  'moment';
export default {
  props: ["data"],
  components: { Favorite },
  data() {
    return {
      editing: false,
      id: this.data.id,
      body: this.data.body
    };
  },
  computed: {
    ago(){
      return moment(this.data.created_at).fromNow()
    },
    signedIn() {
      return window.App.signedIn;
    },
    canUpdate() {
      return this.authorize(user => this.data.user_id == user.id);
    }
  },
  methods: {
    edit() {
      this.editing = true;
      this.body = this.body.replace(/<\/?[^>]+>/gi, "");
    },
    update() {
      axios
        .patch("/replies/" + this.data.id, {
          body: this.body
        })
        .catch(error => {
          flash(error.response.data, "danger");
        });

      this.editing = false;
      flash("Reply Updated Successfully");
    },
    destroy() {
      axios.delete("/replies/" + this.data.id);

      flash("Reply deleted successfully.");
      this.$emit("deleted", this.data.id);
    }
  }
};
</script>