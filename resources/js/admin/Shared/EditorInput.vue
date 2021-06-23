<template>
  <div>
    <label v-if="label" class="form-label text-sm font-semibold" :for="id">{{ label }}:</label>
    <ckeditor :editor="editor" :id="id" ref="input" v-bind="$attrs" class="form-editor" :class="{ error: error }" :value="value" @input="input" :config="editorConfig"></ckeditor>
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
  import CKEditor from '@ckeditor/ckeditor5-vue2';
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

  export default {
    inheritAttrs: false,
    props: {
      id: {
        type: String,
        default() {
          return `editor-input-${this._uid}`
        },
      },
      value: String,
      label: String,
      error: String,
    },
    components: {
      ckeditor: CKEditor.component
    },
    data() {
      return {
        editor: ClassicEditor,
        editorConfig: {
          //The configuration of the editor.
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
