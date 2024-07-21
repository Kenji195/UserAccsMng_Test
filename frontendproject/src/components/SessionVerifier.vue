<script>
    import axios from 'axios';
    export default {
        name: 'SessionVerifier',
        async created() {
            let url = 'http://127.0.0.1:8000/api/me';
            let token = localStorage.getItem('sessionToken');
            if (!token) {
                alert('No session detected');
                this.$router.push('/LoginForm');
            }
            else {
                await axios.post(url, {}, {
                    headers: {
                        'Authorization': 'bearer ' + token
                    }
                }).then((response) => {
                    console.log(response);
                    if (response.status == 200) {
                        if (!response.data.id) {
                            alert('Session expired');
                            this.$router.push('/LoginForm');
                        }
                    }
                }).catch(error => {
                    alert('Error with the session, try logging in again: ' + error);
                    this.$router.push('/LoginForm');
                });
            }
            
        }
    }
</script>