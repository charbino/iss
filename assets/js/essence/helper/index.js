
export const getPath = (instance) => {
    const container = instance.$parent.$el;
    const { path } = container.dataset;

    return path;
};

export const getData = (instance) => {
    const container = instance.$parent.$el;
    const { data } = container.dataset;

    return JSON.parse(data);
};
