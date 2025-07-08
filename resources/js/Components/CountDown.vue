<template>
    <!-- Countdown Timer Section -->
    <div class="bg-sky-800 py-10 border-t border-sky-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6">
          <h2 class="text-2xl font-bold text-white sm:text-3xl">
            Voting Closes In
          </h2>
          <p class="mt-2 text-sky-200">
            Don't miss your chance to support your favorite players and teams
          </p>
        </div>

        <div class="flex justify-center">
          <div class="grid grid-cols-4 gap-4 md:gap-6">
            <!-- Days -->
            <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-lg px-3 py-4 md:px-6 md:py-8 text-center">
              <div class="text-3xl md:text-5xl font-bold text-white mb-1">{{ timeLeft.days }}</div>
              <div class="text-xs md:text-sm text-sky-200 uppercase tracking-wider">Days</div>
            </div>

            <!-- Hours -->
            <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-lg px-3 py-4 md:px-6 md:py-8 text-center">
              <div class="text-3xl md:text-5xl font-bold text-white mb-1">{{ timeLeft.hours }}</div>
              <div class="text-xs md:text-sm text-sky-200 uppercase tracking-wider">Hours</div>
            </div>

            <!-- Minutes -->
            <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-lg px-3 py-4 md:px-6 md:py-8 text-center">
              <div class="text-3xl md:text-5xl font-bold text-white mb-1">{{ timeLeft.minutes }}</div>
              <div class="text-xs md:text-sm text-sky-200 uppercase tracking-wider">Minutes</div>
            </div>

            <!-- Seconds -->
            <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-lg px-3 py-4 md:px-6 md:py-8 text-center">
              <div class="text-3xl md:text-5xl font-bold text-white mb-1">{{ timeLeft.seconds }}</div>
              <div class="text-xs md:text-sm text-sky-200 uppercase tracking-wider">Seconds</div>
            </div>
          </div>
        </div>

        <div class="text-center mt-8">
          <a href="#categories" class="inline-flex items-center bg-white text-sky-800 font-medium px-6 py-3 rounded-lg shadow hover:bg-sky-50 transition-all duration-300 transform hover:scale-105">
            Vote Now
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { ref, onMounted, onBeforeUnmount } from 'vue';

  export default {
    name: 'CountdownTimer',
    props: {
      // You can provide a custom end date as a prop
      targetDate: {
        type: Date,
        default: () => {
          // Default to 45 days from now if not provided
          const date = new Date();
          date.setDate(date.getDate() + 45);
          return date;
        }
      }
    },
    setup(props) {
      const endDate = ref(props.targetDate);
      const timerId = ref(null);

      const timeLeft = ref({
        days: 45,
        hours: 12,
        minutes: 34,
        seconds: 56
      });

      const calculateTimeLeft = () => {
        const now = new Date();
        const difference = endDate.value.getTime() - now.getTime();

        if (difference <= 0) {
          // Timer has ended
          clearInterval(timerId.value);
          timeLeft.value = {
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0
          };
          return;
        }

        // Calculate remaining time
        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        // Update state
        timeLeft.value = {
          days: String(days).padStart(2, '0'),
          hours: String(hours).padStart(2, '0'),
          minutes: String(minutes).padStart(2, '0'),
          seconds: String(seconds).padStart(2, '0')
        };
      };

      onMounted(() => {
        // Calculate initial time
        calculateTimeLeft();

        // Update every second
        timerId.value = setInterval(calculateTimeLeft, 1000);
      });

      onBeforeUnmount(() => {
        // Clean up timer when component is destroyed
        if (timerId.value) {
          clearInterval(timerId.value);
        }
      });

      return {
        timeLeft
      };
    }
  };
  </script>
