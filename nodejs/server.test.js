const isNullChk = require('./server');

it('function test of null check', ()=> {
    expect(isNullChk('aaa')).toBe(false)
});