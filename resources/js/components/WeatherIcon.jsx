import React from 'react';
import PropTypes from 'prop-types';

const weatherIconMapping = {
    '200': 't01d',
    '201': 't01d',
    '202': 't01d',
    '203': 't04d',
    '231': 't04d',
    '232': 't04d',
    '233': 't04d',
    '300': 'd01d',
    '301': 'd01d',
    '302': 'd01d',
    '500': 'r01d',
    '501': 'r01d',
    '502': 'r03d',
    '511': 'r01d',
    '520': 'r01d',
    '500': 'r01d',
    '521': 'r05d',
    '522': 'r01d',
    '600': 's01d',
    '610': 's01d',
    '611': 's05d',
    '612': 's05d',
    '621': 's01d',
    '622': 's02d',
    '623': 's06d',
    '700': 'a01d',
    '711': 'a01d',
    '721': 'a01d',
    '731': 'a01d',
    '741': 'a01d',
    '751': 's01d',
    '800': 'c01d',
    '801': 'c02d',
    '802': 'c03d',
    '803': 'c03d',
    '804': 'c04d',
    '900': 'r01d',
};

const Icon = ({code}) => <img src={`./images/${weatherIconMapping[code]}.png`}/>

Icon.propTypes = {
    code: PropTypes.number.isRequired
}

export default Icon;