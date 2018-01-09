import { createLocalVue, mount, shallow } from 'vue-test-utils';
import GroceryList from '../components/GroceryList.vue';
import expect from 'expect';
import _ from 'lodash';
import axios from 'axios';
import moxios from 'moxios';
import VueRouter from 'vue-router'

const $route = {
    params : {
        id: 1
    }
};

describe('stuff', () => {

    beforeEach(() => {
        global.axios = axios;
        moxios.install();
    });

    afterEach(() => {
        moxios.uninstall();
    });

    it('dsfdsfsdf', (done)=> {
        moxios.stubRequest('/api/v1/grocery-lists/1', {
            status: 200,
            responseText: 'test'
        });

        const localVue = createLocalVue();

        localVue.use(VueRouter);

        let wrapper = shallow(GroceryList, {
            mocks: {
                $route,
            }
        });

        wrapper.vm.getList();

        moxios.wait(()=>{
            done();
        });

        expect(wrapper.vm.showModal).toBe(false);
    });

});
