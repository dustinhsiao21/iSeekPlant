import React, { useRef } from 'react';
import PropTypes from 'prop-types';


const CheckIcon = () => (
    <div className="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg className="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
    </div>
);

const styles = {
    label: "uppercase text-black font-bold",
    select: "appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-2 rounded focus:outline-none focus:bg-white focus:border-gray-500",
    button: "w-1/6 bg-blue-500 text-white rounded showdow-lg p-2 m-2 hover:bg-blue-700",
}

const SelectCity = React.memo(({ cities, handleSubmit, isLoading } ) => {
    const selectedCity = useRef('');
    const handleClick = () => handleSubmit(selectedCity.current.value);

    return (
        <div className="flex items-center justify-center mb-4">
            <div className="flex items-center">
                <label className={styles.label} htmlFor="select-city">
                    Select City:
                </label>
                <div className="relative mx-4">
                    <select className={styles.select} id="select-city" ref={selectedCity} >
                        {cities.map(city => (<option value={city.city_name} key={city.id}>{city.city_name}</option>))}
                    </select>
                    <CheckIcon />
                </div>
            </div>
            <button className={`${styles.button} ${isLoading || "opacity-50"}}`} 
                disabled={isLoading === true} 
                onClick={handleClick}
                >
                    {isLoading === true ? "Loading..." : "Get"}
            </button>
        </div>
    )
});

SelectCity.propTypes = {
    cities: PropTypes.array.isRequired,
    handleSubmit: PropTypes.func.isRequired,
    isLoading: PropTypes.bool.isRequired,
}
export default SelectCity;