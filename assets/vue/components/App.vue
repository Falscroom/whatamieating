<template>
  <div class="meal-container">
    <!-- Logout Button -->
    <button class="logout-button" @click="logout">Logout</button>

    <!-- User's full name and date -->
    <div class="header">
      <h2>{{ mealsData.userFullName }}</h2>
      <h3>{{ mealsData.date }}</h3>
    </div>

    <!-- Meal Choices -->
    <div
        v-for="meal in mealsData.mealChoices"
        :key="meal.type"
        class="meal-type"
    >
      <h2>{{ meal.type }}</h2>
      <ul>
        <li v-for="choice in meal.choices" :key="choice.title">
          <span class="meal-icon">🍽️</span>
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
      mealsData: [],
    };
  },
  mounted() {
    // Load mealsData from the global window object
    if (window.mealsData) {
      this.mealsData = window.mealsData;
    }
  },
  methods: {
    logout() {
      // Redirect to the logout route
      window.location.href = '/logout';
    },
  },
};
</script>

<style scoped>
/* Import Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

/* Meal Container */
.meal-container {
  position: relative; /* Added to position the logout button within this container */
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  font-family: 'Roboto', sans-serif;
  background: linear-gradient(to bottom, #f0f4f8, #d9e2ec);
  min-height: 100vh;
}

/* Logout Button Styles */
.logout-button {
  position: absolute; /* Positioned relative to .meal-container */
  top: 20px;
  right: 20px;
  background-color: #ff6b6b;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.logout-button:hover {
  background-color: #ee5253;
}

/* Header Styles */
.header {
  text-align: center;
  margin-top: 60px; /* Added margin-top to prevent overlap with the logout button */
  margin-bottom: 30px;
}

.header h2 {
  font-size: 2.2rem;
  color: #334e68;
  margin: 0;
}

.header h3 {
  font-size: 1.2rem;
  color: #829ab1;
  margin-top: 5px;
}

/* Meal Type Section Styles */
.meal-type {
  width: 100%;
  max-width: 600px;
  margin-bottom: 25px;
  background-color: #ffffff;
  border-radius: 12px;
  padding: 20px 25px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Meal Choices List Styles */
ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

li {
  font-size: 1.1rem;
  color: #334e68;
  background-color: #f0f4f8;
  padding: 12px 16px;
  margin-bottom: 12px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

li:hover {
  background-color: #d9e2ec;
  transform: translateY(-3px);
}

/* Meal Icon Styles */
.meal-icon {
  margin-right: 10px;
  font-size: 1.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .meal-type {
    max-width: 90%;
    padding: 15px 20px;
  }

  li {
    font-size: 1rem;
    padding: 10px 14px;
  }
}
</style>
