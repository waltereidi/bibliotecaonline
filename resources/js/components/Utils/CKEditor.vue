<template>
    <textarea v-model="dataSource" id="editor"></textarea>
</template>

<script >

export default {
    props: {
        content: {
            type: String,
            required: false,
            default: '',
        },
        width: {
            type: String,
            required: true,
        }


    },
    data() {
        return { dataSource: this.content, }
    },
    mounted() {
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    ]
                }
            }).then(editor => {
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '10em', editor.editing.view.document.getRoot());
                    writer.setStyle('width', this.width, editor.editing.view.document.getRoot());

                });
                window.editor = editor;
            })

            .catch(error => {
                console.error(error);
            });
    }
}

</script>

<style></style>
