<template>
  <div class="meal-container">
    <!-- User's full name and date -->
    <div class="header">
      <h2>{{ mealsData.userFullName }}</h2>
      <h3>{{ mealsData.date }}</h3>
    </div>

    <!-- Loop through meal types (breakfast, lunch) -->
    <div v-for="meal in mealsData.mealChoices" :key="meal.type" class="meal-type">
      <h2>{{ meal.type }}</h2>

      <!-- Loop through meal choices -->
      <ul>
        <li v-for="choice in meal.choices" :key="choice.title">
          {{ choice.title }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      mealsData: [] // Initialize empty
    };
  },
  mounted() {
    // Load mealChoices from the global window object
    if (window.mealsData) {
      this.mealsData = window.mealsData;

      console.log(this.mealsData);
    }
  }
};
</script>

<style scoped>
/* Container for the entire meal section */
.meal-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh; /* Full viewport height */
  background-color: #f4f6f8;
  padding: 20px;
  text-align: center;
  font-family: 'Arial', sans-serif;
}

/* Header section with user info */
.header {
  margin-bottom: 40px;
}

.header h2 {
  font-size: 2rem;
  color: #42b983;
  margin: 0;
}

.header h3 {
  font-size: 1.2rem;
  color: #888;
  margin: 5px 0;
}

/* Style each meal type section */
.meal-type {
  margin-bottom: 40px;
  width: 100%;
  max-width: 500px;
}

/* Subheading for meal types */
.meal-type h2 {
  font-size: 1.8rem;
  color: #34495e;
  margin-bottom: 15px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Meal choices list */
ul {
  list-style-type: none;
  padding: 0;
}

li {
  font-size: 1.1rem;
  color: #333;
  background-color: #ffffff;
  padding: 15px;
  margin-bottom: 10px;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

li:hover {
  background-color: #f0fbf7;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Responsive behavior */
@media (max-width: 768px) {
  .meal-type {
    max-width: 90%;
  }

  li {
    font-size: 1rem;
    padding: 12px;
  }
}
</style>
