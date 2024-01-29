import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom'; // Update import statement

import Login from './auth/login';
import Register from './auth/register';
import TodoList from './components/TodoList';

function App() {
    return (
        <Router>
            <Routes> {/* Use Routes instead of Switch */}
                <Route path="./auth/login" element={<Login />} />
                <Route path="./auth/register" element={<Register />} />
                <Route path="./auth/todoList" element={<TodoList />} />
            </Routes>
        </Router>
    );
}

export default App;
