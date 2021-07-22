<template>
  <div>
    <label v-if="label" class="form-label text-sm font-semibold" :for="id">{{ label }}:</label>
    <editor api-key="no-api-key" :init="config" :id="id" ref="input" v-bind="$attrs" class="form-editor" :class="{ error: error }" :value="value" @input="input"></editor>
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
  import Editor from '@tinymce/tinymce-vue';

  export default {
    name: 'tinymce-input',
    inheritAttrs: false,
    props: {
      id: {
        type: String,
        default() {
          return `tinymce-input-${this._uid}`
        },
      },
      value: String,
      label: String,
      error: String,
    },
    components: {
      editor: Editor
    },
    data() {
      return {
        config: {
          height: 400,
          menubar: false,
          plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
          ],
          toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image fullpage | forecolor backcolor emoticons | preview | code",
          fullpage_default_encoding: "UTF-8",
          fullpage_default_doctype: "<!DOCTYPE html>",
        }
      }
    },
    methods: {
      focus() {
        this.$refs.input.focus()
      },
      select() {
        this.$refs.input.select()
      },
      input(value){
        this.$emit('input', value)
      }
    },
  }
</script>
