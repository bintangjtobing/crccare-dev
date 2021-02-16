import _ from 'lodash';

/**
 * calculate the mean value of a number array
 *
 * @param {number[]} data
 * @return {number}
 */
export const calculateMean = (data) => {
  if (data.length === 0) return 0;

  let total = 0;
  for (const item of data) {
    total += item;
  }

  return total / data.length;
};

/**
 * formula obtained at https://www.mathsisfun.com/data/standard-deviation-formulas.html
 *
 * @param {number[]} data
 * @return {number}
 */
export const calculateStdDeviation = (data) => {
  if (data.length === 0) return 0;

  const mean = calculateMean(data);
  const N = data.length;

  let sigmaResult = 0;
  for (const item of data) {
    sigmaResult += (item - mean) ** 2;
  }

  return Math.sqrt(1 / N * sigmaResult);
};

/**
 * calculate a single P(x) value for Normal Distribution
 *
 * @param {number} x
 * @param {number} mean
 * @param {number} stdDeviation
 * @return {number}
 */
export const calculatePx = (x, { mean, stdDeviation }) => {
  const prefixValue = 1 / (stdDeviation * Math.sqrt(2 * Math.PI));
  const expValue = -((x - mean) ** 2) / (2 * stdDeviation ** 2);

  return prefixValue * Math.exp(expValue);
};

/**
 * calculate normal distribution data for a number array
 *
 * @param {number[]} data
 * @param {number} mean
 * @param {number} stdDeviation
 * @return {number[]}
 */
export const calculateNormalDistribution = (data, { mean, stdDeviation }) => {
  if (data.length === 0) return [];
  return _.map(data, (num) => calculatePx(num, { mean, stdDeviation }));
};

export const calculateQ1 = (data) => {
  const n = data.length;
  const q1Index = 1/4 * (n + 1);
  if (_.isInteger(q1Index)) return data[q1Index - 1];

  const integerPart = Math.floor(q1Index);
  return (data[integerPart - 1] + data[integerPart]) / 2;
};

export const calculateQ3 = (data) => {
  const n = data.length;
  const q3Index = 3/4 * (n + 1);
  if (_.isInteger(q3Index)) return data[q3Index - 1];

  const integerPart = Math.floor(q3Index);
  return (data[integerPart - 1] + data[integerPart]) / 2;
};

export const calculateMedian = (data) => {
  const N = data.length;
  if ((N + 1) % 2 === 0) return data[(N + 1) / 2 - 1];
  return (data[N / 2 - 1] + data[N / 2]) / 2;
};
