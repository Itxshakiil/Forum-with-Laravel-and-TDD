<template>
  <div>
    <p class="p-4 text-2xl">
      <img :src="avatar" alt width="50" height="50" class="rounded-full inline" />
      <span v-text="user.name"></span>
    </p>

    <form v-if="canUpdate" class="px-8 pt-2 mb-4" method="POST" enctype="multipart/form-data">
      <image-upload name="avatar" @loaded="onLoad"></image-upload>
    </form>
  </div>
</template>
<script>
import ImageUpload from "./ImageUpload.vue";
export default {
  props: ["user"],
  components: { ImageUpload },
  data() {
    return {
      avatar: this.user.avatar_path
    };
  },
  computed: {
    canUpdate() {
      return this.authorize(user => user.id === this.user.id);
    }
  },
  methods: {
    onLoad(avatar) {
      this.avatar = avatar.src;
      this.persist(avatar.file);
    },
    persist(avatar) {
      let data = new FormData();
      data.append("avatar", avatar);
      axios.post(`/api/users/${this.user.name}/avatar`, data).then(() => {
        flash("Avatar Updated Successfully");
      });
    }
  }
};
</script>