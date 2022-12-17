<template>
    <application>
        <template v-slot:content>
            <v-container class="pa-4" fluid>
                <v-card>
                    <v-card-title>
                        Domains
                        <div class="flex-grow-1" />
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                            @input="handleSearch"
                        />
                    </v-card-title>
                    <v-data-table
                        :headers="headers"
                        :items="domains"
                        :loading="loading"
                        hide-default-footer
                        disable-sort
                    >
                        <template v-slot:body="{ items }">
                            <tbody>
                                <tr v-for="item in filteredItems" :key="item.id">
                                    <td>
                                        {{ item.domain_name }}
                                    </td>
                                    <td>{{ new Date(item.updated_at).toLocaleString() }}</td>
                                    <td>{{ item.is_idn ? 'Yes' : 'No' }}</td>
                                    <td>{{ item.is_imprinted ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <v-btn icon @click="handleImprint(item, item.id)">
                                            <v-icon>mdi-fingerprint</v-icon>
                                        </v-btn>
                                        <v-btn icon @click="handleDelete(item, item.id)">
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-data-table>
                </v-card>
                <v-btn
                    fab
                    color="primary"
                    bottom
                    right
                    absolute
                    to="/domains/add"
                    >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </v-container>
        </template>
    </application>
</template>

<script>
  import axios from 'axios';

  export default {
    data () {
        return {
            loading: false,
            search: '',
            headers: [
                { text: 'Domain Name', value: 'domain_name', },
                { text: 'Updated At', value: 'updated_at' },
                { text: 'Internationalized', value: 'is_idn' },
                { text: 'Imprinted', value: 'is_imprinted' },
                { text: 'Actions' }
            ],
            domains: [],
        }
    },
    mounted() {
        this.fetchDomains();
    },
    computed: {
      filteredItems() {
      	 var self=this;
         return this.domains.filter(
         function(item) {
           return item.domain_name.toLowerCase().indexOf(self.search.toLowerCase())>=0;
         });
      }
    },
    methods: {
        async fetchDomains() {
            try {
                this.loading = true;
                const domains = await axios.get('/api/domains');
                this.domains = domains.data;
            }
            catch (e) {
                console.log(e);
            }
            finally {
                this.loading = false;
            }
        },
        handleSearch(value) {
            // handle search functionality here
        },
        handleDelete(item, index) {
            axios.delete('/api/domains/'+item.id).then(response => this.domains = this.domains.filter(item => item.id !== index));
        },
        handleImprint(item, index) {
            axios.put('/api/domains/'+item.id).then(function(response){
              console.log(response.data.result);
              if(response.data.result == 'Set to false') {
                item.is_imprinted = false;
              } else {
                item.is_imprinted = true;
              }
            });

        },
    }
  }
</script>
