<template>
  <v-container>
      <v-row>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);">
            <v-card-text>
              <span>邀请成员</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);">
            <v-card-text>
              <span>移除成员</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);">
            <v-card-text>
              <span>申请</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);">
            <v-card-text>
              <span>小组</span>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);">
            <v-card-text>
              <span>座位</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <v-card style="background-color: rgba(242, 242, 242, 1);">
            <v-card-text>
              <span>学号</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col>
          <!-- <v-card style="background-color: rgba(242, 242, 242, 1);">
            <v-card-text>
              <span>邀请成员</span>
            </v-card-text>
          </v-card> -->
        </v-col>
        <v-col></v-col>
      </v-row>
      <v-row>
        <v-col>
          老师
          <v-divider></v-divider>
        </v-col>
      </v-row>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
export default {
  data:() => ({
    lang,
  })
}
</script>

<style>

</style>