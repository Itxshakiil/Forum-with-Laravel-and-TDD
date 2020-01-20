<template>
  <input
    class="px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
    id="avatar"
    type="file"
    accept="image/*"
    required
    @change="onChange"
  />
</template>
<script>
export default {
  methods: {
    onChange(e) {
      if (!e.target.files[0]) return;

      let file = e.target.files[0];

      let reader = new FileReader();

      reader.readAsDataURL(file);

      reader.onload = e => {
        let src = e.target.result;

        this.$emit("loaded", { src, file });
      };
    }
  }
};
</script>