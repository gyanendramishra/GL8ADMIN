<template>
  <div>
    <label v-if="label" class="form-label text-sm font-semibold" :for="id">{{ label }}:</label>
    <select :id="id" ref="input" v-model="selected" v-bind="$attrs" class="form-select focus:outline-none focus:ring-1 focus:ring-indigo-400 focus:border-transparent" :class="{ error: error }">
      <slot />
    </select>
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `select-input-${this._uid}`
      },
    },
    value: [String, Number, Boolean],
    label: String,
    error: String,
  },
  data() {
    return {
      selected: this.value,
    }
  },
  watch: {
    selected(selected) {
      this.$emit('input', selected)
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
  },
}
</script>
