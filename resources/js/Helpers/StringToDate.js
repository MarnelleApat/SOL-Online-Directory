import moment from 'moment';

const stringToDate = (stringData, format) => {
    return moment(stringData).format(format);
}

export default stringToDate

