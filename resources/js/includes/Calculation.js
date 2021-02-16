import _ from 'lodash';

const DAILY_SOIL_INGESTION = {
  CHILD: 0.04,
  ADULT: 0.05,
};

const BODY_WEIGHT = {
  CHILD: 12,
  ADULT: 60,
};

export const Calculation = {
  data: [],
  setData: function (data) {
    Calculation.data = data;
  },

  // ===== calculate G data =====
  getSumG: () => _.sumBy(Calculation.data, 'G'),

  getMeanG: () => {
    if (Calculation.data.length) {
      return Calculation.getSumG() / Calculation.data.length;
    }
    return 0;
  },

  getMaxG: () => {
    const temp = Calculation.data.map((val) => val.G);
    return Math.max(...temp);
  },

  // ===== calculate ecological impact data =====
  getSumEcological: () => _.sumBy(Calculation.data, 'ecologicalImpactScore'),

  getMeanEcological: () => {
    if (Calculation.data.length) {
      return Calculation.getSumEcological() / Calculation.data.length;
    }
    return 0;
  },

  getMaxEcological: () => {
    const temp = Calculation.data.map((val) => val.ecologicalImpactScore);
    return Math.max(...temp);
  },

  // ===== calculate human impact adult data =====
  getSumHumanImpactAdult: () => _.sumBy(Calculation.data, 'humanImpactAdult'),

  getMeanHumanImpactAdult: () => {
    if (Calculation.data.length) {
      return Calculation.getSumHumanImpactAdult() / Calculation.data.length;
    }
    return 0;
  },

  getMaxHumanImpactAdult: () => {
    const temp = Calculation.data.map((val) => val.humanImpactAdult);
    return Math.max(...temp);
  },

  // ===== calculate human impact children data =====
  getSumHumanImpactChild: () => _.sumBy(Calculation.data, 'humanImpactChild'),

  getMeanHumanImpactChild: () => {
    if (Calculation.data.length) {
      return Calculation.getSumHumanImpactChild() / Calculation.data.length;
    }
    return 0;
  },

  getMaxHumanImpactChild: () => {
    const temp = Calculation.data.map((val) => val.humanImpactChild);
    return Math.max(...temp);
  },
};

/**
 *
 * @param {number[]} concentrationSoils                 concentration in soils for all chemicals (mg/g)
 * @param {number[]} RfD                                oral reference dose, should correspond to the concentrationSoils i.e. concentrationSoils[0] should refer to the same chemical as RfD[0]
 * @param {number} bioAccessibility
 * @return {Object}
 */
export const calculateF2 = ({ concentrationSoils, RfD, bioAccessibility = 1 }) => {
  const eChild = _.map(concentrationSoils, (c) => c * DAILY_SOIL_INGESTION.CHILD * bioAccessibility / BODY_WEIGHT.CHILD);
  const eAdult = _.map(concentrationSoils, (c) => c * DAILY_SOIL_INGESTION.ADULT * bioAccessibility / BODY_WEIGHT.ADULT);

  let tshqChild = 0;
  for (let i = 0; i < eChild.length; i++) {
    tshqChild += eChild[i] / RfD[i];
  }

  let tshqAdult = 0;
  for (let i = 0; i < eAdult.length; i++) {
    tshqAdult += eAdult[i] / RfD[i];
  }

  let child;
  if (tshqChild < 0.1) {
    child = 0;
  } else if (tshqChild <= 10) {
    child = 1.5 * (Math.log10(tshqChild) + 1);
  } else {
    child = 3;
  }

  let adult;
  if (tshqAdult < 0.1) {
    adult = 0;
  } else if (tshqAdult <= 10) {
    adult = 1.5 * (Math.log10(tshqAdult) + 1);
  } else {
    adult = 3;
  }

  return { child, adult };
};

/**
 * @param {number[]} concentrationSoils                 concentration in soils for all chemicals (mg/g)
 * @param {number[]} cancerRisk                         r (in the formula)
 * @return {number}
 */
export const calculateF3 = ({ concentrationSoils, cancerRisk }) => {
  let tscs = 0;
  for (let i = 0; i < concentrationSoils.length; i++) {
    tscs += concentrationSoils[i] * cancerRisk[i];
  }

  let f3;
  if (tscs <= 0.000001) {
    f3 = 0;
  } else if (tscs <= 0.001) {
    f3 = Math.log10(tscs / 0.00001) + 1;
  } else {
    f3 = 3;
  }

  return f3;
};

/**
 * @param {number[]} concentrationGroundwater           concentration in Ground water for all chemicals (mg/l)
 * @param {Object} consumption                          { child: 1, adult: 1 }, unit: L/day
 * @param {number[]} RfD                                oral reference dose, should correspond to the concentrationGroundwater i.e. concentrationGroundwater[0] should refer to the same chemical as RfD[0]
 * @param {number} bioAccessibility
 * @return {Object}
 */
export const calculateF5 = ({ concentrationGroundwater, consumption, RfD, bioAccessibility = 1 }) => {
  const wChild = _.map(concentrationGroundwater, (c) => c * consumption.child * bioAccessibility / BODY_WEIGHT.CHILD);
  const wAdult = _.map(concentrationGroundwater, (c) => c * consumption.adult * bioAccessibility / BODY_WEIGHT.ADULT);

  let tghqChild = 0;
  for (let i = 0; i < wChild.length; i++) {
    tghqChild += wChild[i] / RfD[i];
  }

  let tghqAdult = 0;
  for (let i = 0; i < wAdult.length; i++) {
    tghqAdult += wAdult[i] / RfD[i];
  }

  let child;
  if (tghqChild <= 0.1) {
    child = 0;
  } else if (tghqChild <= 10) {
    child = 3 * (Math.log10(tghqChild) + 1);
  } else {
    child = 6;
  }

  let adult;
  if (tghqAdult <= 0.1) {
    adult = 0;
  } else if (tghqAdult <= 10) {
    adult = 3 * (Math.log10(tghqAdult) + 1);
  } else {
    adult = 6;
  }

  return { child, adult };
};

/**
 * @param {number[]} concentrationGroundwater                 concentration in groundwater for all chemicals (mg/g)
 * @param {number[]} cancerRisk                               r (in the formula)
 * @return {number}
 */
export const calculateF6 = ({ concentrationGroundwater, cancerRisk }) => {
  let tgcs = 0;
  for (let i = 0; i < concentrationGroundwater.length; i++) {
    tgcs += concentrationGroundwater[i] * cancerRisk[i];
  }

  let f6;
  if (tgcs <= 0.000001) {
    f6 = 0;
  } else if (tgcs <= 0.001) {
    f6 = 2 * (Math.log10(tgcs / 0.00001) + 1);
  } else {
    f6 = 6;
  }

  return f6;
};

/**
 * @param {number[]} concentrationSurfacewater          concentration in Surface water for all chemicals (mg/l)
 * @param {Object} consumption                          { child: 1, adult: 1 }, unit: L/day
 * @param {number[]} RfD                                oral reference dose, should correspond to the concentrationGroundwater i.e. concentrationGroundwater[0] should refer to the same chemical as RfD[0]
 * @param {number} bioAccessibility
 * @return {Object}
 */
export const calculateF7 = ({ concentrationSurfacewater, consumption, RfD, bioAccessibility = 1 }) => {
  const wChild = _.map(concentrationSurfacewater, (c) => c * consumption.child * bioAccessibility / BODY_WEIGHT.CHILD);
  const wAdult = _.map(concentrationSurfacewater, (c) => c * consumption.adult * bioAccessibility / BODY_WEIGHT.ADULT);

  let tghqChild = 0;
  for (let i = 0; i < wChild.length; i++) {
    tghqChild += wChild[i] / RfD[i];
  }

  let tghqAdult = 0;
  for (let i = 0; i < wAdult.length; i++) {
    tghqAdult += wAdult[i] / RfD[i];
  }

  let child;
  if (tghqChild <= 0.1) {
    child = 0;
  } else if (tghqChild <= 10) {
    child = 3 * (Math.log10(tghqChild) + 1);
  } else {
    child = 6;
  }

  let adult;
  if (tghqAdult <= 0.1) {
    adult = 0;
  } else if (tghqAdult <= 10) {
    adult = 3 * (Math.log10(tghqAdult) + 1);
  } else {
    adult = 6;
  }

  return { child, adult };
};

/**
 * @param {number[]} concentrationSurfacewater                concentration in surface water for all chemicals (mg/g)
 * @param {number[]} cancerRisk                               r (in the formula)
 * @return {number}
 */
export const calculateF8 = ({ concentrationSurfacewater, cancerRisk }) => {
  let tgcs = 0;
  for (let i = 0; i < concentrationSurfacewater.length; i++) {
    tgcs += concentrationSurfacewater[i] * cancerRisk[i];
  }

  let f8;
  if (tgcs <= 0.000001) {
    f8 = 0;
  } else if (tgcs <= 0.001) {
    f8 = 2 * (Math.log10(tgcs / 0.00001) + 1);
  } else {
    f8 = 6;
  }

  return f8;
};

/**
 * @param {number} weightOnAquaticRisk
 * @return {number}
 */
export const calculateF9 = (weightOnAquaticRisk) => {
  if (weightOnAquaticRisk === 0) {
    return 0;
  }
  if (weightOnAquaticRisk <= 100) {
    return 1;
  } else if (weightOnAquaticRisk <= 500) {
    return 2;
  } else if (weightOnAquaticRisk <= 5000) {
    return 3;
  } else if (weightOnAquaticRisk <= 10000) {
    return 4;
  } else {
    return 5;
  }
};

/**
 * @param {string} erosionType            one of ['observation', 'rusle']
 * @param {Object} erosionValues          { observation: 1, rusle: 0 }
 * @return {number}
 */
export const calculateF10 = (erosionType, erosionValues) => erosionValues[erosionType];

/**
 * calculate relative impact from relative growth rate in aquatic environment
 *
 * @param {number} growthRate             should be a percentage number between 0 and 100
 * @return {number}
 */
export const calculateF11 = (growthRate) => {
  if (growthRate <= 10) return 0;
  else if (growthRate <= 50) return 0.05 * (100 - growthRate);
  else return 3;
};

/**
 * calculate relative impact from relative growth rate in terrestrial environment
 *
 * @param {number} growthRate             should be a percentage number between 0 and 100
 * @return {number}
 */
export const calculateF12 = (growthRate) => {
  if (growthRate <= 10) return 0;
  else if (growthRate <= 50) return 0.05 * (100 - growthRate);
  else return 3;
};

/**
 *
 * @param {Object} fileChemicals                    selected chemicals for this calculation
 * @param {Object} chemicals                        all chemicals available
 * @param {Object} humanImpacts                     data in human impact section
 * @param {Object} ecologicalImpacts                data in ecological impact section
 * @param {Object} groundWaterImpacts               data in ground water impact section
 * @return {Object}
 */
export const calculateData = ({ fileChemicals, chemicals, humanImpacts, ecologicalImpacts, groundWaterImpacts }) => {
  // get all data from selected chemicals
  const concentrationSoils = [];
  const concentrationGroundwater = [];
  const concentrationSurfacewater = [];
  const cancerRisk = [];
  const RfD = [];

  _.forEach(fileChemicals, (fileChemical) => {
    concentrationSoils.push(fileChemical.CiS / 1000);
    concentrationGroundwater.push(fileChemical.CiG);
    concentrationSurfacewater.push(fileChemical.CiSW);

    const { chemicalId } = fileChemical;
    cancerRisk.push(chemicals[chemicalId].oralR);
    RfD.push(chemicals[chemicalId].oralS);
  });

  const consumptionGroundWater = {
    child: humanImpacts.hgc,
    adult: humanImpacts.hgco,
  };

  const consumptionSurfaceWater = {
    child: humanImpacts.hswc,
    adult: humanImpacts.hswco,
  };

  const weightOnHumanRisk = humanImpacts.wohr;

  // calculate all F
  const F1 = +humanImpacts.aos;
  const F2 = calculateF2({ concentrationSoils, RfD });
  const F3 = calculateF3({ concentrationSoils, cancerRisk });
  const F4 = +humanImpacts.gep;
  const F5 = calculateF5({ concentrationGroundwater, consumption: consumptionGroundWater, RfD });
  const F6 = calculateF6({ concentrationGroundwater, cancerRisk });
  const F7 = calculateF7({ concentrationSurfacewater, consumption: consumptionSurfaceWater, RfD });
  const F8 = calculateF8({ concentrationSurfacewater, cancerRisk });
  const F9 = calculateF9(ecologicalImpacts.woar);
  const F10 = calculateF10(ecologicalImpacts.erosion, {
    observation: ecologicalImpacts.erosionval,
    rusle: ecologicalImpacts.erosionvals,
  });
  const F11 = calculateF11(ecologicalImpacts.rgrae);
  const F12 = calculateF12(ecologicalImpacts.rgrte);
  const F13 = +humanImpacts.swep;

  // calculate all G
  const G1 = +groundWaterImpacts.loc;
  const G2 = +groundWaterImpacts.splp;
  const G3 = +groundWaterImpacts.dttg;
  const G4 = +groundWaterImpacts.oial;
  const G5 = +groundWaterImpacts.ndgb;
  const G6 = +groundWaterImpacts.aoic;
  const G = G1 * (G4 + G5 + G6) + F1 * G2 * (G3 + G4 + G5 + G6);
  const ecologicalImpactScore = F9 * (F10 + F11) + F12;

  // calculate child score
  const FChildren = F1 * (F2.child + F3) + F4 * (F5.child + F6) + F13 * (F7.child + F8) + F9 * (F10 + F11) + F12;
  const scoreChild = weightOnHumanRisk * FChildren + G;
  const humanImpactChild = F1 * (F2.child + F3) + F4 * (F5.child + F6) + F13 * (F7.child + F8);

  // calculate adult score
  const FAdult = F1 * (F2.adult + F3) + F4 * (F5.adult + F6) + F13 * (F7.adult + F8) + F9 * (F10 + F11) + F12;
  const scoreAdult = weightOnHumanRisk * FAdult + G;
  const humanImpactAdult = F1 * (F2.adult + F3) + F4 * (F5.adult + F6) + F13 * (F7.adult + F8);

  return { child: scoreChild, adult: scoreAdult, FChildren, FAdult, G, ecologicalImpactScore, humanImpactAdult, humanImpactChild };
};

export default Calculation;
