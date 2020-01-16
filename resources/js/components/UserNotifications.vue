<template>
  <div v-if="notifications.length">
    <div>Notifications</div>
    <li v-for="notification in notifications">
      <a
        :href="notification.data.link"
        v-text="notification.data.message"
        @click="markAsRead(notification)"
      ></a>
    </li>
  </div>
</template>
<script>
export default {
  data() {
    return {
      notifications: false
    };
  },
  created() {
    axios
      .get("/profiles/" + window.App.user.name + "/notifications")
      .then(response => (this.notifications = response.data));
  },
  methods: {
    markAsRead(notification) {
      axios
        .delete(
          "/profiles/" +
            window.App.user.name +
            "/notifications/" +
            notification.id
        )
        .then(response => (this.notifications = response.data));
    }
  }
};
</script>