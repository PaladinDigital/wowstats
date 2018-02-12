<template>
    <div class="countdown">
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
        let m = moment(this.date, "YYYY-MM-DD HH:mm");
        window.console.log(moment);
        return m;
      },
      difference() {
        return this.timer.diff(this.now);
      },
      years() {
        return this.timer.diff(this.now, 'years');
      },
      months() {
        const y = this.years;
        let months = this.timer.diff(this.now, 'months');
        if (y > 0 && months > 12) {
          let Ym = y * 12;
          months = months - Ym;
        }
        return months;
      },
      days() {
        const m = this.months;
        let days = this.timer.diff(this.now, 'days');

        if (m >= 1) {
          let fromMonths = this.now.clone();
          fromMonths.add(m, 'months');
          return this.timer.diff(fromMonths, 'days');
        }
        return days;
      },
      hours() {
        // Remove: days, months, years
        let fromDate = this.now.clone();
        fromDate.add(this.years, 'years');
        fromDate.add(this.months, 'months');
        fromDate.add(this.days, 'days');

        return this.timer.diff(fromDate, 'hours');
      },
      minutes() {
        // Remove rounded values.
        let fromDate = this.now.clone();
        fromDate.add(this.years, 'years');
        fromDate.add(this.months, 'months');
        fromDate.add(this.days, 'days');
        fromDate.add(this.hours, 'hours');

        return this.timer.diff(fromDate, 'minutes');
      },
      seconds() {
        // Remove rounded values.
        let fromDate = this.now.clone();
        fromDate.add(this.years, 'years');
        fromDate.add(this.months, 'months');
        fromDate.add(this.days, 'days');
        fromDate.add(this.hours, 'hours');
        fromDate.add(this.minutes, 'minutes');

        return this.timer.diff(fromDate, 'seconds');
      }
    },
    mounted() {
      window.setInterval(() => {
        this.updateNow();
      },1000);
    },
  }
</script>

<style scoped>
    .countdown {
        display: flex;
        flex-direction: row;
    }
    .timer {
        display: flex;
        flex-direction: column;
    }
</style>