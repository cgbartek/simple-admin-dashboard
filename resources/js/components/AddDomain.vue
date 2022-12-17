<template>
    <application>
        <template v-slot:content>
            <v-container class="pa-4" fluid>
                <v-card :loading="loading">
                    <v-card-title>
                        Add Domains
                    </v-card-title>
                    <v-card-text>
                        <v-textarea
                            v-model="domains"
                            filled
                            label="Domains"
                            :placeholder="'example.com\nxn--sxqv5g23dyr3a428a.com\n测试假域名.com'"
                            hint="Enter one domain name per line."
                            persistent-hint
                        />
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" width="100%" @click="handleSave">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-container>
        </template>
    </application>
</template>

<script>
  export default {
    data () {
        return {
            loading: false,
            domains: '',
        }
    },
    methods: {
        handleSave() {
          let lines = this.domains.split('\n');
          let output = {};
          output.lines = lines;

          fetch('/api/domains', {
            method: 'post',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(output)
          })
          .then(res => res.json())
          .then(function(data) {
            let result = data.result;
            if(result) {
              alert(result);
            }
          })
          .catch(function(error) {
            console.log(error);
          });

          this.domains = '';
        }
    }
  }
</script>
