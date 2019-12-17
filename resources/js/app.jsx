import React, { useState, useEffect, useCallback } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Forecast from './components/Forecast';
import SelectCity from './components/SelectCity';
import ErrorMessage from './components/ErrorMessage';
import ErrorBoundary from './components/ErrorBoundary'

const App = () => {
    const [forecast, setForecast] = useState([]);
    const [error, setError] = useState('');
    const [cities, setCities] = useState([]);
    const [isLoading, setIsLoading] = useState(false);

    const handleSubmit = useCallback((selectedCity) => {
        setIsLoading(true);
        setError('');
        setForecast([]);

        axios.get('/api/forecast', {params:{city: selectedCity}})
            .then(response => {
                setForecast(response.data.data);
            }).catch( () => {
                setError('Oooops! Something went wrong with the server!');
            }).finally( () => {
                setIsLoading(false);
            });
    }, []);

    useEffect(()=> {
        setIsLoading(true);
        axios.get('/api/cities').then(response => {
            setCities(response.data)
        }).catch( () => {
            setError('Oooops! Something went wrong with the server!');
        }).finally( () => {
            setIsLoading(false);
        });
    }, []);

    return (
        <ErrorBoundary>
            <div className="flex justify-center pt-6">
                <div className="flex flex-col text-black xl:w-2/3 lg:w-3/4 w-full">
                    <SelectCity cities={ cities } handleSubmit={handleSubmit} isLoading={isLoading}/>
                    <ErrorMessage error={error} />
                    <div className="flex flex-wrap flex-row">
                        {forecast.map(day => (
                            <Forecast 
                                datetime={day.datetime}
                                iconCode={day.weather.code} 
                                description={day.weather.description}
                                precipitation={day.pop}
                                highTemp={day.high_temp}
                                lowTemp={day.low_temp}
                                key={day.ts} 
                            />
                        ))}
                    </div>
                </div>
            </div>
        </ErrorBoundary>
    );
}

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
