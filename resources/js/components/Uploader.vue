<template>
    <div>
        <label for="file">
            Upload
            <input @change="uploadFile" type="file" name="file" id="file">
        </label>
    </div>

</template>
<script>
    export default {
        methods: {
            uploadFile(ev) {
                var formData = new FormData();
                formData.append("file", ev.target.files[0]);
                axios.post('/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    if(response.status == 200 && response.data == 'success') {
                        this.$parent.$emit('pull-data');
                    }
                }).catch((error) => {
                    alert('error!');
                    console.log(error);
                });
            }
        }
    }
</script>
<style scoped lang="scss">
    label {
        position: relative;
        margin: 20px;
        width: calc(100% - 40px);
        height: calc(100vh - 40px);
        border: 3px solid lightgrey;
        border-radius: 3px;
        text-align: center;
        font-size: 50px;
        line-height: 100vh;
        input {
            position: absolute;
            opacity:0;
            top:0px;
            left:0px;
            width: 100%;
            height: 100%;
        }
    }

</style>
