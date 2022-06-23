module.exports = {
  env: {
    node: true,
  },
  extends: ["eslint:recommended", "plugin:vue/vue3-recommended", "prettier"],
  rules: {
    "vue/no-unused-vars": 1,
    "vue/multi-word-component-names": 0,
    semi: [1, "never"],
  },
};
