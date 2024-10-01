<template>
  <div class="meal-container">
    <!-- Logout Button -->
    <button class="logout-button" @click="logout">Logout</button>

    <!-- User's full name and date -->
    <div class="header">
      <h1 v-if="isAchilles">Ахиллес, великий герой, прибыл!</h1>
      <h2>{{ mealsData.userFullName }} <span v-if="isAchilles">🏅</span></h2>
      <h3>{{ mealsData.date }}</h3>

      <!-- Random quote for Achilles -->
      <p v-if="isAchilles" class="random-quote">{{ randomQuote }}</p>
    </div>

    <!-- Meal Choices -->
    <div
        v-for="meal in mealsData.mealChoices"
        :key="meal.type"
        class="meal-type"
    >
      <h2>{{ meal.type }}</h2>
      <ul>
        <li
            v-for="(choice, index) in meal.choices"
            :key="choice.title"
            @click="isAchilles && attackOpponent(meal.type, index)"
            :class="{
            'achilles-item': isAchilles,
            'defeated': isAchilles && isDefeated(meal.type, index)
          }"
        >
          <span class="meal-icon" v-html="getMealIcon(choice.title)"></span>
          {{ choice.title }}
          <span v-if="isAchilles">
            <span v-if="!isDefeated(meal.type, index)">
              — Здоровье противника: {{ getOpponentHealth(meal.type, index) }}%
            </span>
            <span v-else> — Съеден!</span>
          </span>
        </li>
      </ul>
    </div>

    <!-- Health bar for Achilles -->
    <div v-if="isAchilles" class="health-bar">
      <div class="health" :style="{ width: heroHealth + '%' }"></div>
      <p>Твоя сила: {{ heroHealth }}%</p>
    </div>

    <!-- Victory Message -->
    <div v-if="isAchilles && allOpponentsDefeated" class="victory-message">
      <h2>Поздравляем! Все противники повержены!</h2>
      <p>Ты одержал славную победу, Ахиллес!</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      mealsData: [],
      heroHealth: 100,
      randomQuote: '',
      opponents: {},
      healthRegenInterval: null,
    };
  },
  computed: {
    isAchilles() {
      return this.mealsData.userFullName === 'Ахиллес сын Пелея';
    },
    allOpponentsDefeated() {
      if (!this.isAchilles) return false;
      for (let mealType in this.opponents) {
        for (let opponent of this.opponents[mealType]) {
          if (!opponent.defeated) {
            return false;
          }
        }
      }
      return true;
    },
  },
  mounted() {
    // Load mealsData from the global window object
    if (window.mealsData) {
      this.mealsData = window.mealsData;
    }
    if (this.isAchilles) {
      this.randomQuote = this.getRandomQuote();
      this.initializeOpponents();
      this.startHealthRegen();
    }
  },
  beforeDestroy() {
    // Clear the interval when the component is destroyed
    this.stopHealthRegen();
  },
  methods: {
    logout() {
      // Redirect to the logout route
      window.location.href = '/logout';
    },
    getMealIcon(mealTitle) {
      // Custom icons for specific meal titles
      if (this.isAchilles) {
        switch (mealTitle) {
          case 'Гектор – сын царя Трои Приама':
            return '⚔️'; // Sword for Hector
          case 'Пентесилея — царица амазонок':
            return '👑'; // Crown for Penthesilea
          case 'Мемнон — эфиопский царь':
            return '🌍'; // Globe for Memnon
          default:
            return '🍽️'; // Default meal icon
        }
      }
      return '🍽️'; // Default icon for other users
    },
    getRandomQuote() {
      const quotes = [
        'Ахиллес, великий сын Пелея, не знает страха!',
        'Великий герой Троянской войны заслуживает лучших побед!',
        'Гнев Ахиллеса даже богов заставил трепетать!',
      ];
      return quotes[Math.floor(Math.random() * quotes.length)];
    },
    initializeOpponents() {
      // Initialize opponents' health
      this.mealsData.mealChoices.forEach((meal) => {
        meal.choices.forEach((choice, index) => {
          if (!this.opponents[meal.type]) {
            this.opponents[meal.type] = [];
          }
          this.opponents[meal.type][index] = {
            health: 100,
            defeated: false,
          };
        });
      });
    },
    attackOpponent(mealType, index) {
      if (this.heroHealth <= 0) {
        alert('Ты слишком слаб, чтобы сражаться!');
        return;
      }
      const opponent = this.opponents[mealType][index];
      if (opponent.defeated) {
        alert('Противник уже повержен!');
        return;
      }
      // Decrease opponent's health
      opponent.health = Math.max(0, opponent.health - 25);
      // Check if opponent is defeated
      if (opponent.health === 0) {
        opponent.defeated = true;
        alert('Противник съеден!');
        // Check for victory
        if (this.allOpponentsDefeated) {
          this.onVictory();
        }
      } else {
        // Opponent attacks back
        this.heroHealth = Math.max(0, this.heroHealth - 15);
        if (this.heroHealth === 0) {
          alert('Ахиллес пал в бою...');
          this.stopHealthRegen();
        }
      }
    },
    getOpponentHealth(mealType, index) {
      return this.opponents[mealType][index].health;
    },
    isDefeated(mealType, index) {
      return this.opponents[mealType][index].defeated;
    },
    startHealthRegen() {
      // Regenerate health every 2 seconds
      this.healthRegenInterval = setInterval(() => {
        if (this.heroHealth < 100 && this.heroHealth > 0) {
          this.heroHealth = Math.min(100, this.heroHealth + 5);
        }
      }, 5000);
    },
    stopHealthRegen() {
      if (this.healthRegenInterval) {
        clearInterval(this.healthRegenInterval);
        this.healthRegenInterval = null;
      }
    },
    onVictory() {
      alert('Все противники повержены! Ты победил!');
      // You can add more victory effects here
    },
  },
};
</script>

<style scoped>
/* Import Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

/* Meal Container */
.meal-container {
  position: relative;
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
  position: absolute;
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
  margin-top: 60px;
  margin-bottom: 30px;
}

.header h1 {
  font-size: 2.4rem;
  color: #b83280;
  margin-bottom: 10px;
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

.random-quote {
  font-style: italic;
  color: #52796f;
  margin-top: 15px;
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
  position: relative;
}

li:hover {
  background-color: #d9e2ec;
  transform: translateY(-3px);
}

.achilles-item {
  cursor: pointer;
}

.achilles-item:hover::before {
  content: '⚔️';
  position: absolute;
  left: -30px;
  font-size: 1.5rem;
  animation: sword-swing 0.5s ease-in-out;
}

/* Defeated opponent styles */
li.defeated {
  background-color: #ccc;
  text-decoration: line-through;
  pointer-events: none;
}

/* Meal Icon Styles */
.meal-icon {
  margin-right: 10px;
  font-size: 1.5rem;
}

/* Health bar styles */
.health-bar {
  width: 100%;
  max-width: 600px;
  background-color: #d9e2ec;
  border-radius: 12px;
  margin-top: 20px;
  overflow: hidden;
}

.health {
  height: 20px;
  background-color: #ff6b6b;
  transition: width 0.5s ease;
}

/* Victory Message Styles */
.victory-message {
  text-align: center;
  margin-top: 30px;
  padding: 20px;
  background-color: #f0fff4;
  border: 2px solid #38a169;
  border-radius: 12px;
}

.victory-message h2 {
  color: #2f855a;
  font-size: 2rem;
}

.victory-message p {
  color: #276749;
  font-size: 1.2rem;
}

/* Sword swing animation */
@keyframes sword-swing {
  0% {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(30deg);
  }
  100% {
    transform: rotate(0deg);
  }
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
