<template>
    <div>
        {{days}} {{hours}}
    </div>
</template>

<script>
  const moment = require('moment');
  export default {
    props: ['date'],
    data() {
      return {
        now: new moment(),
      }
    },
    methods: {
      updateNow() {
        this.now = moment();
      }
    },
    computed: {
      timer() {
        return moment(this.date, "YYYY-MM-DD HH:mm")
      },
      difference() {
        return this.timer.diff(this.now);
      },
      years() {
        return this.timer.diff(this.now, 'years');
      },
      months() {
        return this.timer.diff(this.now, 'months');
      },
      days() {
        const m = this.months;
        let days = this.timer.diff(this.now, 'days');
        if (m > 1) {
        }
        return days;
      },
    },
    mounted() {
      window.setInterval(() => {
        this.updateNow();
      },1000);
    },
  }
</script>

<style scoped>

</style>