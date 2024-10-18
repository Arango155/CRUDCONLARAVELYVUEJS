<template>
    <div>
        <h1>NASA Data</h1>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Explanation</th>
                    <th>Image</th>
                </tr>
                <tr>
                    <td>{{ nasaData.date }}</td>
                    <td>{{ nasaData.title }}</td>
                    <td>{{ nasaData.explanation }}</td>
                    <td><img :src="nasaData.url" alt="NASA Image" width="200"/></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            nasaData: {},
            loading: true,
        };
    },
    mounted() {
        this.fetchNasaData();
    },
    methods: {
        async fetchNasaData() {
            try {
                const response = await axios.get('/nasa-data');
                this.nasaData = response.data;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
