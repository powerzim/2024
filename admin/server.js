// Rota para obter o total de cliques
app.get('/total-cliques', (req, res) => {
    const queryString = 'SELECT COUNT(*) AS total FROM clicks WHERE page = ?';
    connection.query(queryString, ['../index.html'], (error, results) => {
      if (error) {
        console.error('Erro ao obter total de cliques:', error);
        res.status(500).send('Erro ao obter total de cliques.');
      } else {
        const totalCliques = results[0].total;
        console.log('Total de cliques:', totalCliques);
        res.status(200).json({ totalCliques });
      }
    });
  });
  