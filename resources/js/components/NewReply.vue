<template>
  <div>
    <div v-if="signedIn">
      <div class="mb-4">
        <textarea
          class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
          id="body"
          type="body"
          name="body"
          placeholder="Anything to say?"
          cols="30"
          rows="5"
          required
          v-model="body"
        ></textarea>
      </div>
      <div class="mb-6 text-center">
        <button
          class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
          type="submit"
          @click="addReply"
        >Reply</button>
      </div>
    </div>
    <p class="p-4" v-else>
      Please
      <a href="/login" class="text-blue-500">sign in</a> to participate in the
      discussion
    </p>
  </div>
</template>
<script>
import "jquery.caret";
import "at.js";
export default {
  data() {
    return {
      body: ""
    };
  },
  mounted() {
    $("#body").atwho({
      at: "@",
      delay: 750,
      callbacks: {
        remoteFilter: function(query, callback) {
          $.getJSON("/api/users", { name: query }, function(usernames) {
            callback(usernames);
          });
        }
      }
    });
  },
  methods: {
    addReply() {
      axios
        .post(location.pathname + "/replies", { body: this.body })
        .catch(error => {
          flash(error.response.data, "danger");
        })
        .then(({ data }) => {
          this.body = "";

          flash("Your Reply has been added");

          this.$emit("created", data);
        });
    }
  }
};
</script>