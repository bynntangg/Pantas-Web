// api/index.js - Vercel Serverless Function
const express = require('express');
const cors = require('cors');
const { createClient } = require('@supabase/supabase-js');

const app = express();
app.use(cors({
  origin: ['https://pantas-web.vercel.app/', 'http://localhost:3000'],
  credentials: true
}));
app.use(express.json());

// Supabase config
const supabase = createClient(
  process.env.SUPABASE_URL,
  process.env.SUPABASE_ANON_KEY
);

// Login endpoint
app.post('/api/login', async (req, res) => {
  try {
    const { email, password } = req.body;
    
    const { data, error } = await supabase.auth.signInWithPassword({
      email,
      password
    });
    
    if (error) throw error;
    
    // Ambil data user dari tabel users
    const { data: userData, error: userError } = await supabase
      .from('users')
      .select('*')
      .eq('email', email)
      .single();
    
    if (userError && userError.code !== 'PGRST116') {
      // Jika tabel users belum ada, buat data dasar
      const { data: newUser, error: createError } = await supabase
        .from('users')
        .insert([{ 
          email, 
          name: data.user.user_metadata?.name || email.split('@')[0],
          role: 'customer'
        }])
        .select()
        .single();
      
      if (createError) throw createError;
      
      return res.json({
        success: true,
        token: data.session.access_token,
        user: newUser,
        role: newUser.role
      });
    }
    
    res.json({
      success: true,
      token: data.session.access_token,
      user: userData,
      role: userData?.role || 'customer'
    });
    
  } catch (error) {
    res.status(400).json({
      success: false,
      message: error.message
    });
  }
});

// Register endpoint
app.post('/api/register', async (req, res) => {
  try {
    const { name, email, password, role } = req.body;
    
    // Register ke Supabase Auth
    const { data, error } = await supabase.auth.signUp({
      email,
      password,
      options: {
        data: { name, role }
      }
    });
    
    if (error) throw error;
    
    // Simpan ke tabel users
    const { data: userData, error: userError } = await supabase
      .from('users')
      .insert([{ 
        email, 
        name, 
        role: role || 'customer',
        auth_id: data.user.id
      }])
      .select()
      .single();
    
    if (userError) throw userError;
    
    res.json({
      success: true,
      message: 'Registration successful',
      user: userData
    });
    
  } catch (error) {
    res.status(400).json({
      success: false,
      message: error.message
    });
  }
});

// Logout endpoint
app.post('/api/logout', async (req, res) => {
  try {
    const token = req.headers.authorization?.split(' ')[1];
    if (token) {
      await supabase.auth.admin.signOut(token);
    }
    res.json({ success: true, message: 'Logged out' });
  } catch (error) {
    res.json({ success: true, message: 'Logged out' });
  }
});

module.exports = app;