<template>
    <div>
        <div class="container">
            <div class="row justify-content-center mb-3">
                <div
                    class="col-12 py-3 my-2"
                >
                    <form action="/admin/products/images" class="dropzone needsclick dz-clickable" id="demo-upload" enctype="multipart/form-data">
                        <div>
                            <h3 class="text-center">Drag and drop image(s) here.</h3>
                        </div>
                        <div class="dz-message needsclick" ref="imagesUpload">
                            <button type="button" class="dz-button">Click here to choose the image(s) to upload.</button><br>
                        </div>
                    </form>
                </div>
                <div class="div col-12 my-2">
                    <button class="upload-button" @click="set_product_details()">upload images</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import DropZone from "dropzone";

export default {
    props:{
        token:{
            required: true
        }
    },
    data() {
        return {
            dropzone: null,
        };
    },
    mounted() {
        window.images = new Map();
        DropZone.options.demoUpload = {
            maxFilesize: 3,  // 3 mb
            acceptedFiles: ".jpeg,.jpg,.png",
            paramName: 'images',
            addRemoveLinks: true,
            timeout: 420000,
            uploadMultiple: true,
            renameFile: function(file){
                return new Date().getTime() + '_' + file.name;
            },
            init: function(){
                this.on('sending', function(file, xhr, formData){
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                });

                this.on('success', function(file, response){
                    document.querySelector('.upload-button').style.display = 'block';
                    window.images.set(file.name, response);
                });

                this.on('completemultiple', function(file){
                    document.querySelector('.upload-button').style.display = 'block';
                });

                this.on('removedfile', function(file){
                    let name;
                    if (window.images.has(file.name)) {
                        name = window.images.get(file.name)
                        axios.post('/admin/products/delete', {
                            images: name
                        }).then((res)=>{
                            console.log(res.data);
                        }).catch((err)=>{
                            console.log('err', err);
                        })
                    }
                    
                });
            }
        }
        this.dropzone = new DropZone(this.$refs.imagesUpload, {url: "/admin/products/images"});
    },
    methods: {
        set_product_details(){
            window.location.assign('/admin/products/description')
        }
    }
};
</script>

<style scoped>
    form{
        border: 3px dashed #0d2655;
        border-radius: 10px;
        padding: 1em 3em;
        font-size: 14px;
        text-align: center;
    }

    button.dz-button{
        background: transparent;
        border: 0px;
        outline: none;
    }
    .upload-button {
        display: none;
        width: 100%;
        border: 0px;
        padding: 0.5em;
        border-radius: 0.3em;
        background: cornflowerblue;
        color: white;
        outline: none;
    }
</style>
