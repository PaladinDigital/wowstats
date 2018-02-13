<template>
    <div class="countdown">
        <div class="countdown--value months" v-if="showMonths">
            <span class="value">{{months}}</span>
            <label>m</label>
        </div>

        <div class="countdown--value days" v-if="showDays">
            <span class="value">{{days}}</span>
            <label>d</label>
        </div>

        <div class="countdown--value hours" v-if="showHours">
            <span class="value">{{hours}}</span>
            <label>h</label>
        </div>

        <div class="countdown--value minutes" v-if="showMinutes">
            <span class="value">{{minutes}}</span>
            <label>m</label>
        </div>

        <div class="countdown--value seconds" v-if="showSeconds">
            <span class="value">{{seconds}}</span>
            <label>s</label>
        </div>
    </div>
</template>

<script>
  const moment = require('moment');
  export default {
    props: ['date', 'options'],
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
      },
      showMonths() {
        return (this.months > 0);
      },
      showDays() {
        if (this.showMonths) { return true; }
        return (this.days > 0);
      },
      showHours() {
        if (!this.showMonths) {
          return true;
        }
        return false;
      },
      showMinutes() {
        return this.showHours;
      },
      showSeconds() {
        if (this.showDays || this.showMonths) {
          return false;
        }
        return true;
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
        justify-content: space-between;
    }

    .countdown--value {
        display: flex;
        flex-direction: column;
    }
</style>