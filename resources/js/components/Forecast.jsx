import React from 'react';
import moment from 'moment';
import Icon from './WeatherIcon';
import PropTypes from 'prop-types';

const weekendStyle = ( time ) => time.format('E') >= 6 ? 'text-orange-300' : 'text-white';

const styles = {
    content: "border-2 border-solid border-black-500 bg-gray-700 opacity-75 text-white font-semibold h-full",
}
const Forecast = React.memo(({ datetime, iconCode, description, precipitation, highTemp, lowTemp }) => {
    const time = moment(datetime);

    return (
        <div className="lg:flex-1 md:flex-1 w-full flex flex-col text-center mx-1">
            <div className={`bg-black w-full text-2xl ${weekendStyle(time)}`}>{time.format('ddd')}</div>
            <div className="bg-blue-300 h-1"></div>
            <div className={`flex lg:flex-col md:flex-col sm:flex-row justify-around items-center ${styles.content}`}>
                <div className="flex-1 flex justify-center">
                    <Icon code={iconCode} />
                </div>
                <div className="flex-1 text-3xl">{precipitation} %</div>
                <div className="flex-1 text-3xl">{description}</div>
                <div className="flex-1">
                    <div className="text-4xl font-black text-red-500">{Math.round(highTemp)}</div>
                    <div className="text-2xl font-black text-blue-500">{Math.round(lowTemp)}</div>
                </div>
            </div>
        </div>
    );
})

Forecast.propTypes = {
    datetime: PropTypes.string.isRequired,
    iconCode: PropTypes.number.isRequired,
    description: PropTypes.string.isRequired,
    precipitation: PropTypes.number.isRequired,
    highTemp: PropTypes.number.isRequired,
    lowTemp: PropTypes.number.isRequired,
}

export default Forecast;